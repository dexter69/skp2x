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

	/* 2018.09.11 
		Walidacja po Nowemu
		- używamy custom validation method, która waliduje, czy NiP ma poprawny format oraz czy jest unikalny
			(nie ma takiego w bazie )
		- zwraca true, jeżeli NiP ma poprawy format i jest unikalny lub false, jeżeli któryś z powyższych war.
			nie jest spełniony
		- w zmiennej $nipValidationResult przechowywane są wyniki walidacji:
			9 - nie była dokonywana walidacja
			0 - OK, NIP ma poprawny format i jest unikalny
			1 - NIP ma nieprawidłowy format
			2 - NIP nie jest unikalny
			8 - inny błąd
	*/

	public $validate = [
		'vatno_txt' => [
			'format' => [
				'rule' => 'isNipValid',
        		'message' => 'NIP ma nieprawidlowy format!'
			],
			'unikalny' => [
				'rule' => 'isNipUnique',
        		'message' => 'Ten NIP już istnieje!'
			]			
        ],

        /**/
        'name' => [
            'rule' => 'notEmpty',
            //'required' => true,
            'message' => 'To pole jest wymagane!'
        ]
        
	];	

    private function vatPatterns() {
        /**
         * Thanks to:
         * https://www.braemoor.co.uk/software/vat.shtml         */

        $wzorce = [
            '^(AT)U(\d{8})$',                           //** Austria
            '^(BE)(0?\d{9})$',                          //** Belgium 
            '^(BE)([0-1]\d{9})$',                       //** Belgium - since 01/01/2020
            '^(BG)(\d{9,10})$',                         //** Bulgaria 
            '^(CHE)(\d{9})(MWST|TVA|IVA)?$',            //** Switzerland
            '^(CY)([0-59]\d{7}[A-Z])$',                 //** Cyprus
            '^(CZ)(\d{8,10})(\d{3})?$',                 //** Czech Republic
            '^(DE)([1-9]\d{8})$',                       //** Germany 
            '^(DK)(\d{8})$',                            //** Denmark 
            '^(EE)(10\d{7})$',                          //** Estonia 
            '^(EL)(\d{9})$',                            //** Greece 
            '^(ES)([A-Z]\d{8})$',                       //** Spain (National juridical entities)
            '^(ES)([A-HN-SW]\d{7}[A-J])$',              //** Spain (Other juridical entities)
            '^(ES)([0-9YZ]\d{7}[A-Z])$',                //** Spain (Personal entities type 1)
            '^(ES)([KLMX]\d{7}[A-Z])$',                 //** Spain (Personal entities type 2)
            '^(EU)(\d{9})$',                            //** EU-type 
            '^(FI)(\d{8})$',                            //** Finland 
            '^(FR)(\d{11})$',                           //** France (1)
            '^(FR)([A-HJ-NP-Z]\d{10})$',                // France (2)
            '^(FR)(\d[A-HJ-NP-Z]\d{9})$',               // France (3)
            '^(FR)([A-HJ-NP-Z]{2}\d{9})$',              // France (4)
            '^(GB)?(\d{9})$',                           //** UK (Standard)
            '^(GB)?(\d{12})$',                          //** UK (Branches)
            '^(GB)?(GD\d{3})$',                         //** UK (Government)
            '^(GB)?(HA\d{3})$',                         //** UK (Health authority)
            '^(HR)(\d{11})$',                           //** Croatia 
            '^(HU)(\d{8})$',                            //** Hungary 
            '^(IE)(\d{7}[A-W])$',                       //** Ireland (1)
            '^(IE)([7-9][A-Z\*\+)]\d{5}[A-W])$',        //** Ireland (2)
            '^(IE)(\d{7}[A-W][AH])$',                   //** Ireland (3)
            '^(IT)(\d{11})$',                           //** Italy 
            '^(LV)(\d{11})$',                           //** Latvia 
            '^(LT)(\d{9}|\d{12})$',                     //** Lithuania
            '^(LU)(\d{8})$',                            //** Luxembourg 
            '^(MT)([1-9]\d{7})$',                       //** Malta
            '^(NL)(\d{9}B\d{2})$',                      //** Netherlands
            '^(NL)([A-Z0-9\*\+]{10}\d{2})$',            //** Netherlands sole proprietor
            '^(NO)(\d{9})$',                            //** Norway (not EU)
            '^(PL)(\d{10})$',                           //** Poland
            '^(PT)(\d{9})$',                            //** Portugal
            '^(RO)([1-9]\d{1,9})$',                     //** Romania
            '^(RU)(\d{10}|\d{12})$',                    //** Russia
            '^(RS)(\d{9})$',                            //** Serbia
            '^(SI)([1-9]\d{7})$',                       //** Slovenia
            '^(SK)([1-9]\d[2346-9]\d{7})$',             //** Slovakia Republic
            '^(SE)(\d{10}01)$',                         //** Sweden            
        ];

        return "/" . implode("|", $wzorce) . "/";

    }

	// Sprawdzamy czy NIP ma prawidłowy format
	public function isNipValid( $check ) {        

        $value = array_values($check);
        if( $value[0] == NO_NIP ) {
            return true; // brak NIP'u jest poprawny
        }
		$nip = $this->vatTxtToVatNo( $value[0] );
		
        preg_match( $this->vatPatterns(), $nip, $matches );		
		if( !array_key_exists(0 , $matches) || (strlen($nip) != strlen($matches[0]))  ) { // nieprawidłowy format
			return false;
		}

		return true;
	}
	
	// Sprawdzamy czy NIP jest unikalny
	public function isNipUnique( $check ) {

		$value = array_values($check);
		$nip = $value[0];

		if( $nip ==  NO_NIP ) { // Klient z brakiem NIP'u
			return true; 
		}
		// vatno chcemy bez kresek i spacji
		$this->vatno = $this->vatTxtToVatNo( $nip );

		// poszukajmy czy taki NIP już jest
		$result = $this->find('first', [
			'conditions' => [
				'Customer.vatno' => $this->vatno
				,'Customer.id !=' => $this->id // w wypadku edycji
			]
		]);

		if( !empty($result) ) { // jest już taki NIP
			return false;
		}
		
		return true;
	}	

    /*
	Polerujemy dane, ktore dostaliśmy. Jeżeli $customerId > 0, tzn edycja */
	public function polishData( &$requestData, $customerId = 0) { // oczekuje $this->request->data

        // Wersja tekstowa NIP'u dla czytelności, ale bez brzegowych spacji, małe litery na duże
        $requestData['Customer']['vatno_txt'] = strtoupper(trim($requestData['Customer']['vatno_txt']));

        if( $requestData['Customer']['vatno_txt'] == "#" ) { // skrócona wersja BRAK nipu
            $requestData['Customer']['vatno_txt'] = NO_NIP;
        }
        
        // Pozbywamy się kresek oraz spacji i inne
        $requestData['Customer']['vatno'] = $this->vatTxtToVatNo($requestData['Customer']['vatno_txt']);

        if( $customerId ) { // czyli edycja
            $requestData['Customer']['id'] = 
            $requestData['AdresSiedziby']['customer_id'] = $customerId;
        } else { // tylko dla nowych klientów
            // Kwestie własności
            $requestData['Customer']['user_id'] =
            $requestData['Customer']['owner_id'] =
            // stały opiekun -> ten kto dodaje, staje się stałym opiekunem
            $requestData['Customer']['opiekun_id'] =                
            $requestData['AdresSiedziby']['user_id'] = AuthComponent::user('id');
        }
    }
    
    private function vatTxtToVatNo( $vatTxt ) {        
        
        if( $vatTxt == NO_NIP ) {
            return '000000000'; // wersja dla vatno w przypadku podania BRAK
        }
        // Pozbywamy się kresek oraz spacji oraz małe litery zamieniamy na duże
        return str_replace(' ', '', str_replace('-', '', $vatTxt));
    }


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

/**
 * Zmienna regulująca zależności między wyświetlaniem w widokach a bazą danych
 *
 * @var array
 */

    // formatowania do bootstrap views
    public $boot_view_options = [
        'forma_zaliczki' =>	[
            'label' => 'Forma przedpłaty',			
            'options' => array(NIE=>'BEZ PRZEDPŁATY', PRZE=>'PRZELEW', CASH=>'GOTÓWKA', PAU=>'INNA (UWAGI)'),
            'default' => DEF_ZAL_FORM //defaultowa forma zaliczki
        ],
        'procent_zaliczki' => [
            'label' => '%',						
            "min"  => 1,
            "max"  => 100,
            "value" => 100,
            'required' => true
        ],
        'forma_platnosci' => [ 
            'label' => 'Płatność po',			
            'options' => array(NIE=>'BRAK', PRZE=>'PRZELEW', CASH=>'GOTÓWKA', POB=>'POBRANIE', PAU=>'INNA (UWAGI)'),
            'default' => DEF_PAY_FORM //defaultowa forma platnosci
        ],
        'termin_platnosci' => [
            'label' => 'Termin',			
            'default' => DEF_PAY_TIME, //defaultowo ile dni
            'min' => 1,			
            'disabled' => false,
            'required' => true
        ],
        'cr' => [
            'label' => 'Czas realizacji',			
            'default' => ORD_TIME, //defaultowo ile dni
            'min' => 1,						
            'required' => true
        ],
        'waluta' =>	[					
            'options' => ['PLN'=>'PLN', 'EUR'=>'EUR', 'USD'=>'USD'],
            'default' => 'PLN' //defaultowo PLN
        ],
        'etylang' =>	[	
            'label' => 'Język etykiety',
            'options' => ["pl"=>"Polski", "en"=>"Angielski", "de"=>"Niemiecki"] 			
        ],
        'pozyskany' => [
            'label' => 'Klient pozyskany z:',
            'options' => [
                "bra"=>"Brak informacji",
                "psi"=>"Targi PSI",
                "rem"=>"Tari RemaDays",
                "tar"=>"Inne targi",
                "int"=>"Internet",
                "oso"=>"Pozyskany Osobiście"
            ]
        ]
    ];

    public function boot_view_options( $customer = [] ) {

        if( !empty($customer) ) { // tzn. nowy klient
            $this->boot_view_options['forma_zaliczki']['default'] = $customer['forma_zaliczki'];
            $this->boot_view_options['forma_platnosci']['default'] = $customer['forma_platnosci'];            
        }

        /* Jeżeli klient nie płaci zaliczki lub ma nietypową formę zaliczki,
             * to procent nie ma sensu   */
        if( in_array($this->boot_view_options['forma_zaliczki']['default'], [NIE, PAU]) ) {        
            $this->boot_view_options['procent_zaliczki']['disabled'] = true;
            $this->boot_view_options['procent_zaliczki']['min'] = 
            $this->boot_view_options['procent_zaliczki']['value'] = 0;
        } else {
            $this->boot_view_options['procent_zaliczki']['min'] = 1;
            $this->boot_view_options['procent_zaliczki']['disabled'] = false;
        }

        /* Jeżeli klient nie płaci po, płaci pobraniem lub ma nietypową formę płatności,
             * to ustalanie ilości dni nie ma sensu   */
        if( in_array($this->boot_view_options['forma_platnosci']['default'], [NIE, POB, PAU]) ) {
            $this->boot_view_options['termin_platnosci']['default'] = null;	
            $this->boot_view_options['termin_platnosci']['disabled'] = true;
        } else {
            $this->boot_view_options['termin_platnosci']['disabled'] = false;
        }

        return $this->boot_view_options;
    }

    public function bootConvertDbVal2ViewVal() {
        
    }

/**
 * ##### DEPREC
 */	

    /*
	Obcinamy spacje na początku i na końcu określonych pól modelu*/
	public function trimSpaces( &$requestData ) { // oczekuje $this->request->data

		$requestData['Customer']['vatno_txt'] = trim($requestData['Customer']['vatno_txt']);
		
	}
    
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

		if( $request_data['Customer']['vatno_txt'] ==  NO_NIP ) { // Klient z brakiem NIP'u
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
    
    public $nipValidationResult = 9; // startowa wartość

}
