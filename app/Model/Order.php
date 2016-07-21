<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
 * @property User $User
 * @property Customer $Customer
 * @property Card $Card
 * @property Event $Event
 */
class Order extends AppModel {
	
	// tu wpisujemy kody po jakiejś akcji
	public $OrderError = 0;
        
        // zwróć status przedpłaty
        public function prepaidStatus( $id = null ) {
            //$result = array();
            
            //$this->Behaviors->attach('Containable');
            $result = $this->find('first', array(
                'conditions' => array('Order.id' => $id ),
                'fields' => array('Order.id', 'Order.forma_zaliczki', 'Order.stan_zaliczki', 'Order.zaliczka_toa'),
                'recursive' => 0
                //'contain' => array('Card.id', 'Card.status', 'Card.remstatus')
            ));
            
            return $result;	
        }
        
        // zapisz status przedpłaty
        public function setPrepaidStatus( $rqdata = array() ) {
            
            if ( isset($rqdata['id'], $rqdata['stan_zaliczki']) ) { // zapisz w bazie                
                
                if ( $this->exists($rqdata['id'])) { // jest taki rekord                    
                    $rqdata = $this->savePrePaidInDB($rqdata); }
                else {
                    $rqdata['errno'] = 3; }
            } else {
                $rqdata['errno'] = 2; }
            return $rqdata;
        }
        
        // zapisz, zakładamy, że rqdata jest OK (przygotowane wyżej
        private function savePrePaidInDB( $rqdata = array() ) {
            // nie wiem jak i czy można transportować wartość null json, dlatego tak
            if( $rqdata['stan_zaliczki'] == 'red' ) {
                $rqdata['stan_zaliczki'] = null; 
                $rqdata['zaliczka_toa'] = null; // czerwone, to tak jakby nic nie był robione
            }   else {
                $rqdata['zaliczka_toa'] = date("Y-m-d H:i:s"); }
            $dane['Order'] = $rqdata; // prawidłowy format dla save
            if( $this->save($dane) ) { 
                $rqdata['errno'] = 0; }
            else { 
                $rqdata['errno'] =  1; }            
            return $rqdata;
        }
	
	/*	ZNAJDŹ MI ZAMÓWIENIE i WSZYSTKIE JEGO KARTY,
	INTERESUJĄ NAS TYLKO POLA status */
	public function zamkart_statusy_only( $id = null ) {
		
		$result = array();
		if ( $this->exists($id) ) {
			$this->Behaviors->attach('Containable');
			$result = $this->find('first', array(
						'conditions' => array('Order.id' => $id ),
						'fields' => array('Order.id', 'Order.status', 'Order.remstatus'),
						'contain' => array('Card.id', 'Card.status', 'Card.remstatus')
			));
		}
		return $result;	
	}
        
        public function findOrderByNr($param = NULL) {
		
		if( $param != NULL ) {
                    $this->Behaviors->attach('Containable');
                    $zamowienie = $this->find('first', array(
                                            'conditions' => array('Order.nr' => $param ),
                                            'fields' => array('Order.id', 'Order.nr', 'Order.user_id', 'Order.stop_day'),
                                            'contain' => array('User.id', 'User.inic', 'Card.id' , 'Card.name')
                    ));
                    return $zamowienie;
                }
		return null;
	}
        
        
        public function ordersAndItsCardsOfaCustomer( $klient_id = NULL ) {
            
            $this->Behaviors->attach('Containable');
            $zamowienia = $this->find('all', array(
                'conditions' => array('Order.customer_id' => $klient_id ),
                'fields' => array( 'Order.nr', 'Order.stop_day', 'Order.status' ),
                'contain' => array('User.id', 'User.inic', 'Card.id' , 'Card.name', 'Card.quantity')
            ));
            return $zamowienia;
        }
        
        public function customerRelated( $klient_id = NULL ) {
            
            $ret = array();
            $customer = $this->Customer->find('first', array(
                'conditions' => array('Customer.' . $this->Customer->primaryKey => $klient_id ),
                'recursive' => 0
            ));
            if( !empty($customer) ) { 
                $ret = $customer;  
                $ret['Order'] = $this->ordersAndItsCardsOfaCustomer($klient_id);
            }
            return $ret;
        }
	
	// zwróć status zamówienia lub -1, gdy zamówienie nie istnieje
	public function order_status( $id = null ) {
		
		if ( $this->exists($id) ) {
			$options = array(
				'conditions' => array('Order.' . $this->primaryKey => $id),
				'fields' => array( 'id', 'status'),
				'recursive' => 0
			);
			$order = $this->find('first', $options);
			return $order['Order']['status'];
		}
		
		return -1;
	}
		
	public function get_view_options($edit = false) {
   			
   			// $edit = true; => mamy do czynienia z edycją
   			   			
   			
   			$this->view_options['forma_zaliczki'] = $this->Customer->view_options['forma_zaliczki'];
   			$this->view_options['forma_zaliczki']['required'] = $edit;
   			$this->view_options['forma_zaliczki']['disabled'] = !$edit;
   			
   			$this->view_options['procent_zaliczki'] = $this->Customer->view_options['procent_zaliczki'];
   			$this->view_options['procent_zaliczki']['required'] = $edit;
   			$this->view_options['procent_zaliczki']['disabled'] = !$edit; 						
   			$this->view_options['procent_zaliczki']['default'] = null;
   			
   			
   			$this->view_options['forma_platnosci'] = $this->Customer->view_options['forma_platnosci'];
   			$this->view_options['forma_platnosci']['required'] = $edit;
   			$this->view_options['forma_platnosci']['disabled'] = !$edit;
   			
   			$this->view_options['termin_platnosci'] = $this->Customer->view_options['termin_platnosci'];
   			$this->view_options['termin_platnosci']['required'] = $edit;
   			$this->view_options['termin_platnosci']['disabled'] = !$edit;
   			$this->view_options['termin_platnosci']['default'] = null;
   			
   			$this->view_options['osoba_kontaktowa'] = $this->Customer->view_options['osoba_kontaktowa'];
   			$this->view_options['osoba_kontaktowa']['required'] = $edit;
   			$this->view_options['osoba_kontaktowa']['disabled'] = !$edit;
   			$this->view_options['osoba_kontaktowa']['default'] = null;
   			
   			$this->view_options['tel'] = $this->Customer->view_options['tel'];
   			$this->view_options['tel']['required'] = $edit;
   			$this->view_options['tel']['disabled'] = !$edit;
   			$this->view_options['tel']['default'] = null;
   			
			return array_merge($this->view_options, $this->AdresDostawy->view_options, $this->Card->view_options);
			
		}		
	
	
	// Wczytaj, jeżeli istnieją, karty luzem zalogowanego klienta
	// oraz dane o płatności i adresy siedziby klientów
	public function getTheCardsAndRelated($userid) {
		
		$result = array();
		$kartyall = $this->Card->find('all', array(
			'conditions' => array('Card.owner_id' => $userid, 'Card.order_id' => 0),
			'fields' => array(	'Card.name', 'Card.quantity', 'Card.customer_id', 'Card.order_id',
								'Customer.id', 'Customer.name', 'Customer.forma_zaliczki',
								'Customer.procent_zaliczki', 'Customer.forma_platnosci',
								'Customer.termin_platnosci', 'Customer.osoba_kontaktowa',
								'Customer.tel', 'Customer.cr'),
			'order' => array('Customer.id'),
			'recursive' => 0
		));	
		
		if( !empty($kartyall) ) {
			
			$i=0; $platnosci = array();
			//
			foreach ($kartyall as $value) {
				// dane o opcjach płatności dla każdego klienta dla javascript
				$platnosci[$value['Customer']['id']] = array(
					'forma_zaliczki' => $value['Customer']['forma_zaliczki'],
					'procent_zaliczki' => $value['Customer']['procent_zaliczki'],
					'forma_platnosci' => $value['Customer']['forma_platnosci'],
					'termin_platnosci' => $value['Customer']['termin_platnosci'],
					'osoba_kontaktowa' => $value['Customer']['osoba_kontaktowa'],
					'tel' => $value['Customer']['tel'],
					'cr' => $value['Customer']['cr']
				);
				//adresy siedziby dla javascript
				$wynik = $this->Customer->AdresSiedziby->find('first',array(
							'conditions' => array( 'AdresSiedziby.customer_id' => $value['Customer']['id'])
				));
				$wynik = $wynik['AdresSiedziby'];
				//wyrzucamy niepotrzebne
				unset( $wynik['user_id'], $wynik['customer_id'], $wynik['order_id'], $wynik['modified'], $wynik['created'], $wynik['comment'] );
				$adresy[$value['Customer']['id']] = $wynik;
				$kartyall[$i++]['AdresSiedziby'] = $wynik;
			}
			$platnosci[0] = array( // defaultowe formy płatności
				'forma_zaliczki' => DEF_ZAL_FORM,
				'procent_zaliczki' => DEF_ZAL_PROC,
				'forma_platnosci' => PAY_FORM,
				'termin_platnosci' => PAY_TIME,
				'osoba_kontaktowa' => null,
				'tel' => null,
				'cr' => null
			);
			$result['platnosci'] = $platnosci;
			$result['karty'] = $kartyall;
			$result['adresy'] = $adresy;
		}

		
		return $result;
	}
	
	public $siaErr = 0;
	
	
	/*
		Tutaj będzie wpiywany nr błędu zwracany przez funkcję saveItAll
		
		0 - bez błędu
		1 - inny błąd
		2 - tablica wejściowa pusta
		3 - sprzeczność danych: inny adres dostawy a nie ma danych tego adresu
		4 - nie udało się zapisać adresu dostawy
		5 - saveAssociated nie dało rady
		
	*/
	public function saveItAll( $d2s = array() ) {
		
		$this->siaErr=0;
		if( empty($d2s) ) { $this->siaErr=2; return false; }
		$usid = AuthComponent::user('id'); //zalogowany użytkownik
		if( $d2s['Order']['sposob_dostawy'] == 2 ) { 
			// tzn. że adres dostawy jest inny niż na fakturze
			if( empty($d2s['AdresDostawy']) ) {
				$this->siaErr=3; return false;	
			}
			// wszystko ok próbujemy zapisać nowy adres
			
			//zalogowany użytkownik jest twórcą rekordu
			$d2s['AdresDostawy']['user_id'] = $usid;
			$this->AdresDostawy->create();
			if( $this->AdresDostawy->save($d2s['AdresDostawy']) ) 
				// zpisaliśmy, super, id nowego rekordu to adres dostawy
				$d2s['Order']['wysylka_id'] = $this->AdresDostawy->id;
			else {
				$this->siaErr=4; return false;
			}
		}
		else {
			//nie ma dodatkowego adresu, adres dostawy jak na fakturze
			$d2s['Order']['wysylka_id'] = $d2s['Order']['siedziba_id'];
			
		}
		unset($d2s['AdresDostawy']); //nie jest potrzebne już
		// W tym momencie pozostaje zapisać zlecenie i "updatować" karty
		$d2s['Order']['user_id'] = $usid;
		//$this->print_r2($d2s);
		//return;
		$this->create();
		if( $this->saveAssociated($d2s  /*,array('validate' => false)*/ ) ) return true;
		else {
			$this->siaErr=5; return false;
		}
	}
	
	
	// Przygotuj format danych, usuń zbędne itp.
	public function cleanData($inarr = array()) {
		
		$result = array();
		$i=0;
		if( array_key_exists('id', $inarr['Order']) )
			$edit = true; //mamy do czynienia z edycją
		else 
			$edit = false;	//mamy do czynienia z nowym zleceniem
		
		if( $edit ) {
		/*	edycja, interesują nas checked
			(nowe lub mogło się coś zmienić w starych) oraz te unchecked,
			które mają order_id != 0 (tzn. że użytkownik odznaczył karty
			tego zlecenia) pozostałe unchecked, to (o ile istnieją)
			nowe "nie podpięte karty", które nie zostały wybrane.
			
		*/	
			$inarr['Order']['count_checked'] = 0;
			foreach ( $inarr['Card'] as $value) {
				
				if( $value['checked'] || $value['order_id'] )	 {
				// to oznacza każdą kartę poza nową i nie wybraną
					if( $value['checked'] ) {
						$inarr['Order']['count_checked']++; // liczyme ilośc checked kart
						$value['ilosc'] = str_replace(',', '.', $value['ilosc']);
						$value['quantity']=$value['ilosc']*$value['mnoznik'];
						unset($value['checked']/*, $value['order_id']*/);
						//zamieniamy ew przecinek w cenie na '.'
						$value['price'] = str_replace(',', '.', $value['price']);
						$value['order_id'] =  $inarr['Order']['id'];
					
					}
					else { // karta, którą chcemy odpiąć
						$value['order_id']  = $value['quantity'] = 0;
						$value['price'] = $value['ilosc'] = null;
						$value['mnoznik'] = 1;
						//zmiany ilosci i cen nieistotne, chcemy tylko odpiąć kartę
						//unset($value['checked'], $value['ilosc'], $value['mnoznik'], $value['price']);
						unset($value['checked']);
					}
				$result[$i++] = $value;
				}	
				
				
			}
			$inarr['Card'] = $result;
			//$this->print_r2($result);
			//return;
			// ###########################
			// OPCJE PŁATNOŚCI
			if( $inarr['Order']['count_checked'] ) 
			// w przeciwnym wypadku zlecenie idzie do usunięcia i nie ma się co nim zajmować
			{
				if(	$inarr['Order']['forma_zaliczki'] == NIE ||
					$inarr['Order']['forma_zaliczki'] == PAU )
						$inarr['Order']['procent_zaliczki'] = NULL;
				if(	$inarr['Order']['forma_platnosci'] == NIE || $inarr['Order']['forma_platnosci'] == PAU
					 || $inarr['Order']['forma_platnosci'] == POB )
						$inarr['Order']['termin_platnosci'] = NULL;	
		
			//
				if ( $inarr['Order']['sposob_dostawy'] != IA ) {
					if ( $inarr['Order']['sposob_dostawy'] == NAF )
						$inarr['Order']['wysylka_id'] = $inarr['Order']['siedziba_id'];
					else
						$inarr['Order']['wysylka_id'] = 0;
					if( array_key_exists('AdresDostawy', $inarr) && $inarr['AdresDostawy']['id'] == null )
						unset( $inarr['AdresDostawy']); //bo pusta
				}
				else
					$inarr['AdresDostawy']['customer_id'] = 0;//$inarr['Order']['customer_id'];
			}	
			
		}
		else {
			//mamy do czynienia z nowym zleceniem, interesują nas tylko checked
			
			foreach ( $inarr['Card'] as $value) {
				if( $value['checked'] ) {
					$value['ilosc'] = str_replace(',', '.', $value['ilosc']);
					$value['quantity']=$value['ilosc']*$value['mnoznik'];
					unset($value['checked']);
				
					//zamieniamy ew przecinek w cenie na '.'
					$value['price'] = str_replace(',', '.', $value['price']);
					$result[$i++] = $value;
				}
			}
			$inarr['Card'] = $result;
			if( empty( $inarr['Card'] ) ) { 
			//tzn. że użytkownik nie wybrał żadnej karty. tzw. puste zlecenie
				$inarr['Order']['customer_id'] = 0;
            	$inarr['Order']['siedziba_id'] = 0;
			}
			if( array_key_exists('sposob_dostawy', $inarr['Order']) ) {
				switch( $inarr['Order']['sposob_dostawy'] ) {
					case NAF: //na adres faktury
						$inarr['Order']['wysylka_id'] = $inarr['Order']['siedziba_id'];
						unset( $inarr['AdresDostawy']);
						break;
					case IA: //inny (nowy) adres
						$inarr['AdresDostawy']['customer_id'] = 0;//$inarr['Order']['customer_id'];
						break;
					default: // OO lub PAU
						$inarr['Order']['wysylka_id'] = 0;
						unset( $inarr['AdresDostawy']);
				}
			}	
		}
		
		$inarr['Order']['stop_day'] = array(
			'day' => substr($inarr['Order']['hdate'], -2),
			'month' => substr($inarr['Order']['hdate'], 5, 2),
			'year' => substr($inarr['Order']['hdate'], 0, 4)			
		);
		unset($inarr['Order']['hdate']);
		
		return $inarr;
	}
	
	
	/*
		Tutaj będzie wpiywany nr błędu zwracany przez funkcję saveItAll
		
		0 - bez błędu
		1 - inny błąd
		6 - tablica wejściowa pusta
		 - sprzeczność danych: inny adres dostawy a nie ma danych tego adresu
		7 - nie udało się zapisać adresu dostawy
		8 - próba usunięcia nieistniejącego rekordu
		10 - saveAssociated nie dało rady
		9 - nie udało się usunąć rekordu Adresu
		
	*/
	
	public $eiaErr = 0;
	
	public $succMsg = null;
	
	public function editItAll( $d2s = array() ) {
		
		$this->eiaErr=0; 
		
		$this->succMsg = 'Zamówienie zostało zapisane.'; // sukces message 1
		
		if( empty($d2s) ) { $this->siaErr=6; return false; }
		
		//polegamy na funkcji cleanData w dostarczeniu prawidlowych danych
		$d2s = $this->cleanData($d2s);
		
		//najpierw zajmijmy sie adresem dodatkowym jeżeli to konieczne
		if( array_key_exists('AdresDostawy',$d2s) ) {
			/* trzy możliwe rzeczy:
				1. Trzeba go usunąć z bazy
				2. Trzeba go updatować
				3. Trzeba dodać nowy
			*/
						
			if( isset($d2s['AdresDostawy']['id']) && $d2s['Order']['sposob_dostawy'] != IA ) {
				// 1. Usuń ten adres
				$this->AdresDostawy->id = $d2s['AdresDostawy']['id'];
				if (!$this->AdresDostawy->exists()) {
					$this->siaErr=8; return false;
				}
				if ( !$this->AdresDostawy->delete() ) {
					$this->siaErr=9; return false;
				}
			}
			else {
				// 2. lub 3. - reguluje id
				if( !isset( $d2s['AdresDostawy']['id'] ) )  { //bedzie nowy rekord
					//zalogowany użytkownik jest twórcą rekordu
					$d2s['AdresDostawy']['user_id'] = AuthComponent::user('id');
					$this->AdresDostawy->create();
				}
				if( $this->AdresDostawy->save($d2s['AdresDostawy']) ) 
					// zpisaliśmy, super, id nowego rekordu to adres dostawy
					$d2s['Order']['wysylka_id'] = $this->AdresDostawy->id;
				else {
					$this->siaErr=7; return false;
				}
				
				
			}
			unset($d2s['AdresDostawy']); // nie jest już potrzebne
		
		}
			
		//^^^^^ 
		
		//próbujemy zapisać wszystkie karty
		if( $this->Card->saveMany($d2s['Card']) ) {
			//udało się, no to samo zlecenie
			if( $d2s['Order']['count_checked'] == 0 ) { //przypadek odłączenia wszystkich kart
				// usuń puste zlecenie
				$this->delete($d2s['Order']['id'], false);
				$this->eiaErr=15;
				$this->succMsg = 'Karty odłączone. Puste zlecenie usunięte.'; // sukces message 2
				return true;
			} else
				if( $this->save($d2s['Order']) ) {
				//udało się
					$this->eiaErr=12;
					return true;
				}
				else {
					$this->eiaErr=11; return false;
				}
		} else {
			$this->eiaErr=10; return false;
		}
	}	

	// nadaj zleceniu numer po publikacji, zakładamy, że id właśnie zapisanego rekordu jest w $this->id
	public function set_order_number() {
		
		$this->OrderError = 0; //brak błędu
		$id = $this->id;
		if( $id ) {
			if( $this->exists($id) ) {
				//znajdz ostatni nr
				$rekord = $this->find('first', array(
        			'conditions' => array('OR' => array(
        				'Order.nr !=' => null,
        				'Order.id' => 1
        			)),
        			'order' => array('Order.nr' => 'desc')
    			));
    			if( !empty($rekord) ) {
					if( $rekord['Order']['id'] == 1 && $rekord['Order']['nr'] == null ) //pierwszy nr
						$new_nr = FIRST_ORDER_NR;
					else 
						$new_nr = $rekord['Order']['nr']+1;					
					$dane = array( 
							'Order' => array(
								'id' => $id,
								'nr' => $new_nr
					));
					
					if( $this->save($dane) ) 
						return true;
					else {
						$this->OrderError = 1;
						return false;
					}
				} else {
					$this->OrderError = 2;
					return false;
				}
			} else {
				$this->OrderError = 3;
				return false;
			}
			return true;
		} else {
			$this->OrderError = 4;
			return false;
		}
	
	}
	

	// formatowania do views
	public $view_options = 
            array (
                'stop_day' => array( 
                    'label' => 'Data zakończenia',
                    'dateFormat' => 'DMY',
                    'monthNames' => array(
                                    '01'=>'Styczeń',
                                    '02'=>'Luty',
                                    '03'=>'Marzec',
                                    '04'=>'Kwiecień',
                                    '05'=>'Maj',
                                    '06'=>'Czerwiec',
                                    '07'=>'Lipiec',
                                    '08'=>'Sierpień',
                                    '09'=>'Wrzesień',
                                    '10'=>'Październik',
                                    '11'=>'Listopad',
                                    '12'=>'Grudzień'
                    )/**/

                ),
                    /**/
                'forma_zaliczki'    =>	array( 
                    'label' => 'Zaliczka?',
                    'options' => array(
                                        null => '- WYBIERZ -',
                                        NIE=>'NIE',
                                        PRZE=>'PRZELEW',
                                        CASH=>'GOTÓWKA',
                                        LAC=>'UWAGI'),
                    'default' => DEF_ZAL_FORM, 
                    'disabled' => true
                ),							

                    'procent_zaliczki'=>	array( 
                                                            'label' => '%',
                                                            //'disabled' => true,
                                                            'div' => array('class' => 'platnosci2 input number', 'id' => 'procent'),
                                                            'default' => DEF_ZAL_PROC, //defaultowo 100%
                                                            'disabled' => true
                                                    ),							
                    'forma_platnosci'=>	array( 
                                                            'label' => 'Płatność',
                                                            //'div' => array( 'id' => 'xxx'),
                                                            'options' => array(
                                                                    PRZE=>'PRZELEW', PAY_FORM=>'BRAK', 
                                                                    CASH=>'GOTÓWKA', POB=>'POBRANIE', LAC=>'UWAGI'),
                                                            'default' => PAY_FORM //defaultowo nie, bo zaliczka 100%
                                                    ),
                    'termin_platnosci'=> array( 
                                                            'label' => 'Termin (dni)',
                                                            'div' => array('class' => 'platnosci2 input number', 'id' => 'payterm'),
                                                            'required' => true,
                                                            'default' => PAY_TIME //defaultowo 0 dni, bo zaliczka 100%
                                                    ),
                    'sposob_dostawy'	=>	array( 
                                                            'label' => 'Adres dostawy',
                                                            //'label' => false,
                                                            'options' => array(	NAF => 'NA ADRES FAKTURY',
                                                                                                    IA => 'INNY ADRES', OO => 'ODBIÓR OSOBISTY',
                                                                                                    PAU => 'PATRZ UWAGI'),
                                                            'div' => array('id' => 'dostava_div')
                                                            //'div' => false
                                                            //'default' => 7 //defaultowo ile dni
                                                    ),
                    'osoba_kontaktowa'	=>	array( 
                                                            //'label' => '...',

                                                    ),
                    'tel'=>	array( 
                                                            'label' => 'Telefon'

                                                    ),
                    'comment'=>	array( 
                                                            'label' => false

                                                    )				


            );
		

//The Associations below have been created with all possible keys, those that are not needed can be removed



/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
		'AdresDostawy' => array(
            'className' => 'Address',
            'foreignKey' => 'wysylka_id'
            
        ),
		'AdresDoFaktury' => array(
            'className' => 'Address',
            'foreignKey' => 'siedziba_id'
            
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
			'foreignKey' => 'order_id',
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
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'order_id',
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
		'nr' => array(
			'rule' => 'isUnique',
			'message'  => 'Numer zlecenia musi być unikalny!'
		),
		'sposob_dostawy' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
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
		),/*
		'procent_zaliczki' => array(
			'numeric' => array(
				'rule' => array('numeric'),*/
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			/*),
		),*/
		'forma_platnosci' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),/*
		'termin_platnosci' => array(
			'numeric' => array(
				'rule' => array('numeric'),*/
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			/*),
		),*/
		'osoba_kontaktowa' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tel' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
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
	

}
