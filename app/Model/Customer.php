<?php
App::uses('AppModel', 'Model');
/**
 * Customer Model
 *
 * @property User $User
 * @property Card $Card
 * @property Order $Order
 */
class Customer extends AppModel {
    
    //opcje zaliczki jeszcze raz
    private $opcje_zaliczki = array(
        NIE => 'bez przedpłaty',
        PRZE => 'przelew',
        CASH => 'gotówka',
        PAU => 'inna (uwagi)'
    );
    
    //opcje płatności jeszcze raz
    private $opcje_platnosci = array(
        NIE => 'brak',
        PRZE => 'przelew',
        CASH => 'gotówka',
        POB => 'pobranie',
        PAU => 'inna (uwagi)'
    );
    
    // przekształć wartość formy zaliczki w bazie na formę dla widoku
    private function bazaFormaZal2viewFormat( $bazowaFormZal = null ) {
        
        if( $bazowaFormZal == null ) {
            return null;
        } else {
            return $this->opcje_platnosci[$bazowaFormZal];
        }
        
    }
    
    // przekształć wartość opcji platnosci w bazie na formę dla widoku
    private function bazaOpcjaPlatnosci2viewFormat( $bazowaFormPla = null ) {
        if( $bazowaFormPla  == null ) {
            return null;
        } else {
            return $this->opcje_zaliczki[$bazowaFormPla];
        }
    }
    /* Chcemy klientów, którzy coś zamówili w 2015 */
    public function aktywni2015() {
        
        $this->Behaviors->attach('Containable');
        $dane = $this->find('all', array(
                //'conditions' => array( 'Customer.waluta !='  => 'PLN' ),
                'fields' => array('Customer.id', 'Customer.name', 'Customer.waluta'),
                'contain' => array(
                                'Order.id', 'Order.nr', 'Order.stop_day',
                                'Order.data_publikacji',
                                'AdresSiedziby.kraj'
                )                
        ));
        $wyniki = $this->oczyscDo2015($dane);
        //$wyniki = $this->oczyscDoZagranicznych($dane);
        return $wyniki;
    }
    
    // tylko zagraniczni
    private function oczyscDoZagranicznych( $tab = array() ) {
        
        $tablica = $tab;
        $aktywni = 0;
        
        foreach( $tab as $row ) {
            $kr = $row['AdresSiedziby']['kraj'];
            if( !empty($row['Order']) ) {
               if( $kr != 'Polska' && $kr != 'POLSKA') {
                    $aktywni++;
                } 
            }
            
        }
        
        return array( 'tablica' => $tablica, 'aktywni' => $aktywni);
    }
    
    
    // Funkcja wyrzuca klientów, którzy nie mają zamówień złożonych w 2015
    private function oczyscDo2015( $tab = array() ) {
        
        $aktywni = 0;
        $tablica = $tab;
        $kl = 0;
        foreach( $tab as $row ) {
            $i=0;
            foreach( $row['Order'] as $order ) {
                if( $order['data_publikacji'] < '2014-01-01' ) {
                    unset( $tablica[$kl]['Order'][$i] );
                }
                $i++;
            }
            if( !empty($tablica[$kl]['Order'])  ) {
                //unset( $tablica[$kl]['Order'] );
                $aktywni++;
            }
            $kl++;
        }
        
        return array( 'tablica' => $tablica, 'aktywni' => $aktywni);
    }
    
    public function customerRelated( $klient_id = NULL ) {
            
            $ret = array();
            $customer = $this->find('first', array(
                'conditions' => array('Customer.' . $this->primaryKey => $klient_id ),
                'recursive' => 0
            ));
            if( !empty($customer) ) { 
                $ret = $customer;  
                $ret['Customer']['forma_zaliczki_txt'] = $this->bazaFormaZal2viewFormat($ret['Customer']['forma_zaliczki']);
                $ret['Customer']['forma_platnosci_txt'] = $this->bazaFormaZal2viewFormat($ret['Customer']['forma_platnosci']);
                $ret['Order'] = $this->Order->ordersAndItsCardsOfaCustomer($klient_id);
                $ret['Card'] = $this->Card->cardsAndItsOrdersJobsOfaCustomer($klient_id);
                $ret['User'] = $this->Creator->inicjaly();
            }
            return $ret;
        }
    
/*
 * ###################################
 */

        // znajdź klientów po nazwie
	public function findCustomerByName($param = NULL) {
		
		if( $param != NULL ) {
                    $this->Behaviors->attach('Containable');
                    $klienci = $this->find('all', array(
                            'conditions' => array( 'Customer.name LIKE' => '%'.$param.'%'),
                            'fields' => array('Customer.id', 'Customer.user_id', 'Customer.name'),
                            'contain' => array(                                
                                'Owner.name'
                            )
                    ));
                    return $klienci;
                }
		return null;
	}
	
	/*
		Zwraca:
		0 - NIP jest OK i nie ma takiego w bazie,
		1 - NIP ma nieprawidłowy format,
		2 - jest już taki NIP w bazie */
	public function validateNIP(  &$request_data ) {

		/*	Chcemy następujący wzorzec:
			- 0-3 zaków, będących dużą literą
			- jedna cyfra
			- dowolna ilośc cyfr lub "-"
			- ostatni znak, to cyfra
			LUB zamiast NIP'u mamy słowo "BRAK" - dla klientów bez NIP'u */

		$nip = $request_data['Customer']['vatno_txt']; // Wpisany przez handlowca
		
		preg_match( NIP_PATTERN, $nip, $matches );		
		if( !array_key_exists(0 , $matches) || (strlen($nip) != strlen($matches[0]))  ) { // nieprawidłowy format
			return 1;
		}
		if( $this->jestJuzTakiNIP( $request_data ) ) { // taki NIP jest już w bazie			
			return 2;
		}
		return 0; // Wsio OK
	}
	
	/* Sprawdza, czy podany przez handlowca NIP jest już w bazie */
	private function jestJuzTakiNIP( &$request_data) {

		if( $request_data['Customer']['vatno'] ==  NO_NIP ) { // Klient z brakiem NIP'u
			return false; // sytuacja OK
		}
		// Chodzi chyba o sprawdzenie, czy edycja
		//$cid = array_key_exists('id' , $request_data['Customer']) ? request_data['Customer']['id'] : 0;

		$cid = 0;
		if( array_key_exists('id' , $request_data['Customer']) ) {
			$cid = $request_data['Customer']['id'];
		}


		// vatno chcemy bez kresek
		$request_data['Customer']['vatno'] = str_replace('-', '', $request_data['Customer']['vatno_txt']);

		// poszukajmy czy taki NIP już jest
		$result = $this->find('first', array(
					'conditions' => array(
						'Customer.vatno' => $request_data['Customer']['vatno'],
						'Customer.id !=' => $cid )
		));

		if( !empty($result) ) { // jest już taki NIP
			$request_data['result'] = $result;
			return true;
		}
		return false;
	}
	

/**
 * Zmienna regulująca zależności między wyświetlaniem w widokach a bazą danych
 *
 * @var array
 */
	
	// formatowania do views
	public $view_options = 
		array (
			'owner_id'=>	array( //Creator
								'label' => 'Owner',
							 	'div' => array('id' => 'user_id_div'),
								'options' => array(), //wpisujemy w kontrolerze
								'default' => 0 //wpisujemy w kontrolerze
							),	
			'name'=>	array( 
								'label' => 'Nazwa (skrócona)',
							 	'div' => array('id' => 'name_div'),
							 	//'placeholder' => 'Nazwa (skrócona)'
							),							
			'fullname'=>	array( 
								'label' => 'Nazwa (pełna)',
							 	'div' => array('id' => 'fullname_div')
							),
			'ulica'=>	array( 
								//'label' => '...',
							 	'div' => array('id' => 'ulica_div')
							),							
			'nr_budynku'=>	array( 
								'label' => 'Nr',
							 	'div' => array('id' => 'nr_budynku_div')
							),						
			'kod'=>	array( 
								'label' => 'Kod',
							 	'div' => array('id' => 'kod_div')
							),	
			'miasto'=>	array( 
								//'label' => '...',
							 	'div' => array('id' => 'miasto_div')
							),
			'kraj'=>	array( 
								//'label' => '...',
							 	'div' => array('id' => 'kraj_div')
							),																						
			'vatno'		=>	array( 
								//'label' => 'XXX',
							 	//'div' => false,
								//'type' => 'hidden',
								'default' => '000000000' //bedziemy wpisywac w kontrolerze or modelu
						),					
			'vatno_txt'=>	array( 
								'label' => 'NIP',
							 	//'div' => array('id' => '...')
							),		

			'waluta'=>	array( 
								//'label' => 'XXX',
							 	'div' => array('id' => 'waluta_div'),
								'options' => array('PLN'=>'PLN', 'EUR'=>'EUR', 'USD'=>'USD'),
								'default' => 'PLN' //defaultowo PLN
							),
			'cr' => array(		
								'div' => array('id' => 'cr_div'),
								'label' => 'Czas realizacji',
								'default' => ORD_TIME,
								'required' => true,
								'min' => 1
							),
			'osoba_kontaktowa'=>	array( 
								//'label' => '...',
							 	'div' => array('id' => 'osoba_kontaktowa_div')
							),
			'tel'=>	array( 
								'label' => 'Telefon',
							 	'div' => array('id' => 'tel_div')
							),
			'email'=>	array( 
								'label' => 'e-mail',
							 	'div' => array('id' => 'email_div')
							),
			'forma_zaliczki'=>	array( 
								'label' => 'Forma przedpłaty',
							 	'div' => array('class' => 'platnosci1 input select'),
								'options' => array(NIE=>'BEZ PRZEDPŁATY', PRZE=>'PRZELEW', CASH=>'GOTÓWKA', PAU=>'INNA (UWAGI)'),
								'default' => DEF_ZAL_FORM //defaultowa forma zaliczki
							),															
			'procent_zaliczki'=>	array( 
								'label' => '%',
							 	'div' => array('id' => 'proc_div', 'class' => 'platnosci2 input number'),
								'default' => DEF_ZAL_PROC, //defaultowy %
								'disabled' => false,
								'required' => true,
								'min' => 0,
								'max' => 100
							),							
			'forma_platnosci'=>	array( 
								'label' => 'Płatność po',
							 	'div' => array('class' => 'platnosci1 input select'),
								'options' => array(NIE=>'BRAK', PRZE=>'PRZELEW', CASH=>'GOTÓWKA', POB=>'POBRANIE', PAU=>'INNA (UWAGI)'),
								'default' => DEF_PAY_FORM //defaultowa forma platnosci
							),
			'termin_platnosci'=>	array( 
								'label' => 'Termin',
							 	'div' => array('id' => 'term_div', 'class' => 'platnosci2 input number'),
								'default' => DEF_PAY_TIME, //defaultowo ile dni
								'min' => 1,
								//'max' => 90, testowałem, diała!
								'disabled' => false,
								'required' => true
							),
			'newcustomer' => [
								'label' => 'Klient',
								'default' => null, //defaultowo klient stały
								'options' => [null=>"- wybierz -", false => 'STAŁY', true => 'NOWY'],
								'required' => true
							],
			'comment'	=>	array( 
								'label' => 'Uwagi',
								'rows' => '3',
							 	'div' => array('id' => 'comment_div')
							)									
			
		);
	
		public function get_view_options( $customer = array() ) {
			
                    $this->view_options['owner_id']['options'] = $this->Owner->find('list');
                    $this->view_options['owner_id']['default'] = AuthComponent::user('id');
                    $this->view_options['etylang'] = $this->etyk_view['etylang'];

                    if( !empty($customer) ) { // tzn. edycja
                            $this->view_options['forma_zaliczki']['default'] = $customer['forma_zaliczki'];
                            $this->view_options['forma_platnosci']['default'] = $customer['forma_platnosci'];
                    }

                    if( $this->view_options['forma_zaliczki']['default'] == NIE || $this->view_options['forma_zaliczki']['default'] == PAU ) {
                            $this->view_options['procent_zaliczki']['disabled'] = true;
                            $this->view_options['procent_zaliczki']['required'] = false;
                            $this->view_options['procent_zaliczki']['default'] = null;
                    } else {
                            $this->view_options['procent_zaliczki']['disabled'] = false;
                            $this->view_options['procent_zaliczki']['required'] = true;
                    }

                    if( $this->view_options['forma_platnosci']['default'] == NIE ||
                            $this->view_options['forma_platnosci']['default'] == POB ||
                            $this->view_options['forma_platnosci']['default'] == PAU
                    ) {
                            $this->view_options['termin_platnosci']['default'] = null;	
                            $this->view_options['termin_platnosci']['disabled'] = true;
                            $this->view_options['termin_platnosci']['required'] = false;
                    } else {
                            $this->view_options['termin_platnosci']['disabled'] = false;
                            $this->view_options['termin_platnosci']['required'] = true;
                    }
                    return $this->view_options;
		}
		
	
	
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'owner_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

		'vatno' => array(
			//'notEmpty' => array(
				//'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		),
		'vatno_txt' => array(
			//'notEmpty' => array(
				//'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		),
		'forma_zaliczki' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'procent_zaliczki' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'forma_platnosci' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'termin_platnosci' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

    public $hasOne = array(
        'AdresSiedziby' => array(
            'className' => 'Address',
            'foreignKey' => 'customer_id'
            
        )
    );

/**
 * belongsTo associations
 *
 * @var array
 */
	
	public $belongsTo = array(
        'Creator' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
        ),
        'Owner' => array(
            'className' => 'User',
            'foreignKey' => 'owner_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
        )
    );

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Card' => array(
			'className' => 'Card',
			'foreignKey' => 'customer_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'customer_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	
	


}
