<?php
App::uses('AppModel', 'Model');
/**
 * Card Model
 *
 * @property User $User
 * @property Customer $Customer
 * @property Project $Project
 * @property Order $Order
 * @property Job $Job
 * @property Event $Event
 */
class Card extends AppModel {


/**
 * Zmienna regulująca zależności między wyświetlaniem w widokach a bazą danych
 *
 * @var array
 */
	public $farby_na_sito = array (
                '0'	=>	'BRAK',	//nie ma podkładu z sita
                '2'	=>	'SREBRO 303',
                '3'	=>	'ZŁOTO 3002',
                '4'	=>	'ZŁOTO 3003',
                '6'	=>	'PERŁA 38001',
                '7'	=>	'PERŁA 44001',
                '8'     =>      'BIAŁY',
                '1'	=>	'INNY'	//inny kolor - uwagi												
        );	
								
	public function saveitAll( $puc = array(), &$errno ) { 
		
		// puc <=> project, upload and card data
		/*
			$errno - numery błędów:
			
			0 - bez błędu
			1 - inny błąd
			2 - pusta tablica wejściowa
			3 - 
			4 - pliki przeniesione do uploads, ale nie udało się w bazie zapisac info
			5 - liczba wysłanych plików różna od liczby zapisanych
			6 - nie udało się projektu zapisać
			7 - coś nie tak z edycją, id karty = 0 ?
		*/
		
		$errno = $this->prepare_4S($puc, $edycja);
                if( $errno )	{ return false; }
		
		$errno = $this->takeCareFiles_4S($puc, $edycja, $wynik);
                if( $errno )	{ return false; }
		
		// zapisaliśmy z sukcesem pliki powyżej, w $out mamy tablice z identy-
		// fikatorami zapisanych rekorów w uploads
		
				
		// przepisujemy projekt/dane karty
		$ready = array();
		$ready['Card'] = $puc['Card'];
		
		// teraz chcemy połączyć te dane z ewentualnymi starymi plikami (od innych)
		// kart, dołączonymi do tego projektu
		$ready['Upload'] = array('Upload' => array());
		if( !empty($puc['Wspolne']) ) { 
			// znaczy mamy jakies pliki z bazy, ale pozbądźmy się
			// ewentualnie tych, które nie są tego klienta - stare
			foreach ( $puc['Wspolne'] as $key => $value ) {
				if( $value['taken'] )
					$ready['Upload']['Upload'][] = $value['id'];
			}			
		}
		
		
		$ready['Upload']['Upload'] = array_merge( $ready['Upload']['Upload'], $wynik['out'] );
		
		//czyściymy w razie co tekst personalizacji, jeżeli użytkownik nie wybrał jej
		if( $ready['Card']['isperso'] == ZIRO ) $ready['Card']['perso'] = null;
		if( !$edycja )
			$ready['Card']['status'] = PRIV; //pocztątkowy stan karty
		else {
			// potrzebny nam status zamówienia
			$dane = $this->find('first', array(
				'conditions' => array('Card.id' => $ready['Card']['id'] ),
				'fields' => array('Order.id', 'Order.status'),
				'recursive' => 0
			));			
			if( $ready['Card']['status'] != PRIV && $ready['Card']['status'] != NOWKA &&
                            $dane['Order']['status'] != W4UZUP && AuthComponent::user('dzial') != SUA ) {
			// edycja, więc resetujemy status karty do ponownego sprawdzenia, pod warunkiem,
			// że nie jest to edycja karty prywatnej, NOWKA na wszelki wypadek, bo nie pamiętam
			// czy gdzieś jest używane, oraz zamówienie nie jest W4UZUP i nie edytuje Super Admin
                                if( $ready['Card']['isperso'] ) { $ready['Card']['status'] = W4DP; }
                                else { $ready['Card']['status'] = W4D; }
			}
		}
		if( !$edycja ) $this->create();
		if( $this->save($ready) ) {
			$errno = $this->Upload->eventually_kosz( $wynik['remove'] );
			return TRUE; 
		}
		else {
			$errno = 6;
			return FALSE;
		}
			
		
	
	

	}



	// dla saveitAll
	private function prepare_4S( &$puc = array() , &$edycja) { 
	
		$errno=0;	$edycja = false;
		if ( empty($puc) ) $errno = 2;
		
		// sprawdzamy czy mamy do czynienia z dodawanie nowej karty czy z edycją
		if( array_key_exists('id' ,$puc['Card']) ) {
                        if( $puc['Card']['id'] == 0 ) { $errno = 7; }
			else { $edycja = true; }
		}
		
		
		
		//uzupełniamy indeksy
		
		if( !$edycja && !$errno ) { //ale nie edytujemy twórcy
			//zalogowany użytkownik jest twórcą rekordu
			$puc['Card']['user_id'] = AuthComponent::user('id');
			
			$oid = $this->Customer->find('first', array(
				'conditions' => array('Customer.id' => $puc['Card']['customer_id'] ),
				'fields' => array('owner_id')
				));
			$puc['Card']['owner_id'] = $oid['Customer']['owner_id'];
			//pozostale indeksy zerowe
			$puc['Card']['order_id'] = $puc['Card']['job_id'] = 0;
		}
		
		return $errno;
	
	}


	private function takeCareFiles_4S( &$puc = array() , &$edycja, &$zwrot) { 
	
		$in = $remove = array();
		$zwrot = array(); $errno = 0;
		//$errno = 'takeCareFiles_4S';
		if( $edycja && array_key_exists('Zalaczone', $puc) ) {
			
			//zajmij się plikami, ktore są już załączone
			// Zapisz w Uploads - może coś sie zminilo
			$rezultat = $this->Upload->edytuj_zalaczone($puc['Zalaczone']);
			$in = $rezultat['edit'];
			$remove = $rezultat['remove'];
			
		}
		
		// prubujemy zapisać uploadowane pliki (te uploodowane i/lub edytowane wcześniej uplodowane)
		if ( count( $puc['Upload']['files'] )!=1 || $puc['Upload']['files'][0]['error']!=UPLOAD_ERR_NO_FILE ) 
			//tzn. załączono jakies pliki
			$in = array_merge($in, $this->Upload->manage_posted_files($puc));
		
		
		$out = $this->Upload->my_saveMany( $in );
		if( !empty($in) && empty($out) ) $errno = 4;
		else
			if( count($in)!= count($out) ) $errno = 5;
		
		$zwrot = array('in' => $in, 'out' => $out, 'remove' => $remove);
		return $errno;
	}
	
	public function findCardByName($param = NULL) {
		
		if( $param != NULL ) {
                    $karty = $this->find('all', array(
                            'conditions' => array( 'Card.name LIKE' => '%'.$param.'%'),
                            'fields' => array('Card.id', 'Card.user_id', 'Card.name'),
                            'recursive' => 0
                    ));
                    return $karty;
                }
		return null;
	}
        
        public function findCardByName2($param = NULL) {
		
		if( $param != NULL ) {
                    $this->Behaviors->attach('Containable');
                    $karty = $this->find('all', array(
                            'conditions' => array( 'Card.name LIKE' => '%'.$param.'%'),
                            'fields' => array('Card.id', 'Card.user_id', 'Card.name'),
                            'contain' => array(
                                'Order.id', 'Order.nr', 'Order.stop_day',
                                'Job.id', 'Job.nr',
                                'Customer.id', 'Customer.name',
                                'Creator.inic'
                            )
                    ));
                    return $karty;
                }
		return null;
	}
	
	public function findPropperUploads() {
		
		
		$karty = $this->find('all', array(
			'conditions' => array(	'Card.owner_id' => AuthComponent::user('id'),
									'Card.order_id' => 0
			),
			'fields' => array('Card.name', 'Card.customer_id', 'Customer.name')
		));
		//$result = 
		$wspolne = $uplids  = array();
		//$wspolne = array();
		//$uplids  = array();
		$i=0;
		foreach ($karty as $value) {
			foreach ($value['Upload'] as $upload)	{
				//$result[$upload['id']] = $upload['filename'].' [ '.$upload['roletxt'].' ]';
				
				if (array_key_exists( $upload['id'], $uplids )) {
					$wspolne[$uplids[$upload['id']]]['cardname'] .= ', ' . $value['Card']['name'];
				}
				else {
					$wspolne[$i] = array(
						'id' => $upload['id'],
						'filename' => $upload['filename'],
						'roletxt' => $upload['roletxt'],
						'customer_name' => $value['Customer']['name'],
						'customer_id' => $value['Card']['customer_id'],
						'cardname' => $value['Card']['name']
					);
					$uplids[$upload['id']] = $i++;	
				}
			}
  		}
		
		//return $result;
		//return array($result, $karty, $wspolne);
		return $wspolne;
	}
        
        
        public function cardsAndItsOrdersJobsOfaCustomer( $klient_id = NULL ) {
            
            $this->Behaviors->attach('Containable');
            $karty = $this->find('all', array(
                'conditions' => array('Card.customer_id' => $klient_id ),
                'fields' => array( 'Card.id', 'Card.name', 'Card.order_id', 'Card.quantity', 'Card.status'),
                'contain' => array(
                        //'Creator.id', 'Creator.inic',
                        'Order.nr' , 'Order.stop_day', 'Order.user_id',
                        'Job.nr'
                    )
            ));
            return $karty;
        }


//The Associations below have been created with all possible keys, those that are not needed can be removed

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
        ),
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'job_id',
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
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'card_id',
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
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Upload' => array(
			'className' => 'Upload',
			'joinTable' => 'cards_uploads',
			'foreignKey' => 'card_id',
			'associationForeignKey' => 'upload_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

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
		'customer_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'order_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'job_id' => array(
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
		/*
		'quantity' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => true,
				//'required' => 'update',
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		*/
		'wzor' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),/*
		'comment' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*//*
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
		'a_material' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_material' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_c' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_c' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_m' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_m' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_y' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_y' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_k' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_k' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_pant' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_pant' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_lam' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_lam' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mag' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_podklad' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_wybr' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_podklad' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_wybr' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_zadruk' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_zadruk' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_podpis' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_podpis' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_zdrapka' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_zdrapka' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_lakpuch' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_lakpuch' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_lakblys' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_lakblys' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'isperso' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'dziurka' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'chip' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ksztalt' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'hologram' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);
	
	
	// ######################################
	// formatowania do views
	public $view_options = 
		array (
			'name'=>	array( 
								'label' => 'Nazwa karty',
							 	//'div' => array('id' => ''),
								//'options' => array('1'=>'xxx', '2'=>'yyy', '3'=>'zzz'), 
								//'default' => 1 
							),
			'quantity'=>	array( 
								'label' => false,
							 	'div' => false,
								//'required' => false
								//'options' => array('1'=>'STANDARD PVC', '2'=>'BIO PVC', '3'=>'TRANSPARENT'), 
								//'default' => 0 //
							),
			'ilosc'=>	array( 
								'label' => false,
							 	'div' => false,
								'required' => false,
								//'options' => array('1'=>'STANDARD PVC', '2'=>'BIO PVC', '3'=>'TRANSPARENT'), 
								//'default' => 0 //,
								'min' => 1
							),
			'mnoznik'=>	array( 
								'label' => false,
							 	'div' => false,
								//'required' => true
								'options' => array('1'=>'szt.', '1000'=>'tys.', '1000000'=>'mln.'), 
								'default' => 2 //
							),
			'price'=>	array( 
								'label' => false,
							 	'div' => false,
								//'options' => array('1'=>'STANDARD PVC', '2'=>'BIO PVC', '3'=>'TRANSPARENT'), 
								//'default' => 1 //
								'required' => false,
								//'step' => 0.0001,
								//'min' => 0.0001,
								'type' => 'text'
							),
			'wzor'=>	array( 
								'label' => 'Wzory/Załączniki',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(NIE=>'BRAK', 2 => 'KARTA WZORCOWA', 3=>'CROMALIN',
												 	4 => 'WYDRUK CYFROWY', 5 => 'POWTÓRKA (UWAGI)',
													PAU => 'PATRZ UWAGI'
								), 
								'default' => NIE //
							),
			'x_material'=>	array( 
								'label' => false,
							 	'div' => false, //array('id' => 'user_id_div'),
								'options' => array('1'=>'STANDARD PVC', '2'=>'BIO PVC', '3'=>'TRANSPARENT'), 
								'default' => 1 //
							),
			// x_c, x_m, x_y, x_k - CMYK dla awers i rewers
			'x_c'=>	array( 
								'label' => false,
							 	'div' => false,//array('id' => 'user_id_div'),
								'options' => array(1 => 'C', 0 => '-'), 
								//'type' => 'checkbox',
								'default' => 1 //
							),
			'x_m'=>	array( 
								'label' => false,
							 	'div' => false, //array('id' => 'user_id_div'),
								'options' => array(1 => 'M', 0 => '-'),  
								//'type' => 'checkbox',
								'default' => 1 //
							),
			'x_y'=>	array( 
								'label' => false,
							 	'div' => false, //array('id' => 'user_id_div'),
								'options' => array(1 => 'Y', 0 => '-'),  
								//'type' => 'checkbox',
								'default' => 1 //
							),
			'x_k'=>	array( 
								'label' => false,
							 	'div' => false, //array('id' => 'user_id_div'),
								'options' => array(1 => 'K', 0 => '-'),  
								//'type' => 'checkbox',
								'default' => 1 //
							),
			'x_pant'=>	array( 
								'label' => false,
							 	'div' => false, //array('id' => 'user_id_div'),
								'options' => array(0,1,2,3,4), 
								//'default' => 2 //
							),
			'x_lam'=>	array( 
								'label' => false,
							 	'div' => false, //array('id' => 'user_id_div'),
								'options' => array('2'=>'BŁYSZCZĄCY', '3'=>'GŁADKI', '4'=>'CHROPOWATY'), 
								'default' => 2 //
							),
			'mag'=>	array( 
								'label' => 'Pasek magnetyczny',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array('0'=>'BRAK', '1'=>'HiCo', '2'=>'LoCo'), 
								'default' => 0 //
							),
			'x_sito'=>	array( 
								'label' => false,
							 	'div' => false, //array('id' => 'user_id_div'),
								'options' => array(), 
								'default' => 0 //
							),
			'x_wybr'=>	array( 
								'label' => false,
							 	'div' => false, //array('id' => 'user_id_div'),
								'options' => array(
												NIE	=>	'NIE',
												TAK	=>	'TAK' //1 - zarezerw na inny
											), 
								'default' => NIE //
							),							
							
			'x_podpis'=>	array( 
								'etykieta' => 'PASEK DO PODPISU',
								'label' => false,
								'div' => false,
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(
									BRAK	=>	'BRAK',	
									//'1' =>	'INNY', /* zarezerwowane */
									TRAN	=>	'PRZEŹROCZ.', //Pasek do podpisu - przeźroczysty
									BIAL	=>	'BIAŁY', //Pasek do podpisu - biały
								), 
								'default' => 0 //
							),
			'dziurka'=>	array( 
								//'label' => 'PASEK DO PODPISU',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(
												'0'	=>	'BRAK',	//nie ma 
												'2'	=>	'OKRĄGŁA',
												'3'	=>	'OWALNA',
												'4' =>	'EURO',
												'1'	=>	'INNA'
											), 
								'default' => 0 //
							),
			'chip'=>	array( 
								//'label' => 'PASEK DO PODPISU',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(
												'0'	=>	'BRAK',	//nie ma 
												'2'	=>	'UNIQUE',
												'3'	=>	'MIFARE',
												'4'	=>	'SLE',
												'1' =>	'INNY'
											), 
								'default' => 0 //
							),
			'ksztalt'=>	array( 
								//'label' => 'PASEK DO PODPISU',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(
												'0'	=>	'STANDARD',
												'2'	=>	'"2+1"',
												'3' =>	'"Brelokx3"',
												'1'	=>	'INNY'
											), 
								'default' => 0 //
							),
			'hologram' =>	array(	//'label' => 'PERSONALIZACJA', 
									//'div'  => array('id'=>'..'),
									//'type' => 'text',
									'options' => array(
												NIE	=>	'NIE',
												TAK	=>	'TAK' 
											),
									'default' => 0
							),
			'yesno'=>	array( 
								'label' => false,
							 	'div' => false,
								'options' => array(
												false	=>	'NIE',
												true	=>	'TAK' 
											), 
								'default' => false //
							),
			'sito_comment' =>	array( 
								'label' => 'UWAGI DO SITODRUKU',
							 	
							),
			'cmyk_comment' =>	array( 
								'label' => 'UWAGI DO OFFSETU',
							 	
							),
			'isperso' =>	array(	'label' => false, //'PERSONALIZACJA', 
									'div'  => false, //array('id'=>'pchoose'),
									//'type' => 'text',
									'options' => array(
												ZIRO	=>	'NIE',
												JEDEN	=>	'TAK' 
											),
									'default' => ZERO
							),
			'perso' =>	array(	'label' => false, 
								'div'  => array('id'=>'ptext')
								/*	'div'  => false,
									'type' => 'text',
									'default' => 0*/
							),
			'option_comment' =>	array( 
								'label' => 'UWAGI',
							 	
							),
			'comment' =>	array( 
								//'label' => 'UWAGI DO CAŁEGO PROJEKTU',
								'label' => false,
							 	//'div' => array('id'=>'finaluw')
							 	'div' => false
							)							
		);
		
		public function get_view_options() {
   
			// 
			$this->view_options['x_sito']['options'] = $this->farby_na_sito;
			$this->view_options['name'] = $this->view_options['name'];
			$this->view_options['file'] = $this->Upload->view_options['file'];
			$this->view_options['role'] = $this->Upload->view_options['role'];
			$this->view_options['roletxt'] = $this->Upload->view_options['roletxt'];
			return $this->view_options;
		}
			

}
