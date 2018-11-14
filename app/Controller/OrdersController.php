<?php
App::uses('AppController', 'Controller');


/**
 * Orders Controller
 *
 * @property Order $Order
 * @property PaginatorComponent $Paginator
 */
class OrdersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        
    public $helpers = array('Pdf', 'Ma');
	
	public $paginate = array(
            'order' => array(
                'Order.nr' => 'desc'
            )
        );
	
	public function beforeFilter() {
            parent::beforeFilter();
            //$this->actionAllowed();
            $this->links = array( nORD_LIST, nORD_ADD, nORD_EDIT, nORD_DEL );
            $this->set('links', $this->links );
	}	

        
	private function zakoncz_zamowienie($id = null) {
		
		
		$opcje = array( 
			'conditions' => array( 'Order.id' => $id ),
			'fields' => array('Order.id', 'Order.status'),
			'recursive' => 1
		);
		$rez = $this->Order->find( 'first', $opcje );
		$things2end['Order'] = $rez['Order'];	
		$things2end['Order']['status'] = KONEC;
		foreach( $rez['Card'] as $karta )	{
			$things2end['Card'][] = array( 'id' => $karta['id'], 'job_id' => $karta['job_id'], 'status' => KONEC );
			$tmp[$karta['job_id']] = true;
		}
		foreach( $tmp as $key => $value ) $jobtab[] = $key;
		
		$opcje = array( 
			'conditions' => array( 'Job.id' => $jobtab ),
			'fields' => array('Job.id', 'Job.status'),
			'recursive' => 1
		);
		$joby = $this->Order->Card->Job->find( 'all', $opcje );
		
		
		$jobyaffected = array();
		foreach( $joby as $row ) { //
			$tenjob = true;
			foreach( $row['Card']  as $kartazjoba )	{
				if( $kartazjoba['order_id'] != $things2end['Order']['id'] &&
					$kartazjoba['status'] != KONEC ) {
						$tenjob = false;
				}
			}
			if( $tenjob ) {
				$row['Job']['status'] = KONEC;
				$jobyaffected[] = $row['Job'];
			}
		}
		
		
		
		$wynik = array('ok' => true, 'msg' => 'ALL gites!');
		
		if( $this->Order->saveAssociated($things2end) ) {
			if( !empty($jobyaffected) )
				if( !$this->Order->Card->Job->saveMany($jobyaffected) )
					$wynik = array('ok' => false, 'msg' => 'Nie moge zakończyć zleceń/nia');
		} else
		 	$wynik = array('ok' => false, 'msg' => 'Nie moge zakończyć zamówienia id = '.$things2end['Order']['id']);
				
		return $wynik;
	}

	public function zakord_old( $term = null ) {
		
		if( $term != null && $this->Auth->user('dzial') == SUA) {
			$opcje = array(
				'conditions' => array(
					'Order.stop_day <=' => $term,
					'Order.status !=' => KONEC
				)
			);
			$ordy = $this->Order->find( 'list', $opcje );
			if( empty($ordy) )
				$zam = 'Nie ma co zakańczać!';
			else {
				foreach( $ordy as $id ) {
					$wynik = $this->zakoncz_zamowienie( $id );
					if( !$wynik['ok'] ) {
						break;
					}
				}
				$zam = $wynik['msg'];
			}
		} else
			$zam = 'Nie ma co zakańczać!';
			
		$this->set( compact('zam') );
		$this->render('zakoncz');	
	}
	
	public function zakord( $par = null ) {
		
		
		if( $par != null && $this->Auth->user('dzial') == SUA) 	{
			
			$t_ids = explode(',', $par);																	
			$opcje = array(
				'conditions' => array( 'Order.id' => $t_ids, 'Order.status !=' => KONEC	)
			);	
			$ordy = $this->Order->find( 'list', $opcje );
			if( empty($ordy) )
				$zam = 'Nie ma co zakańczać!';
			else {
				$zam = $ordy;
				
				foreach( $ordy as $id ) {
					$wynik = $this->zakoncz_zamowienie( $id );
					if( !$wynik['ok'] ) {
						break;
					}
				}
				$zam = $wynik['msg'];
				
			}
		
		} else
			$zam = 'Nie ma co zakańczać!';
			
		$this->set( compact('zam') );
		$this->render('zakoncz');
	
	}
		



/**
 * index method
 *
 * @return void
 */
	public function index($par = null) {
		
		//$time_start = microtime(true);
		
		
		//$this->Order->recursive = 0;
		$this->Paginator->settings = $this->paginate;
		
		if( !$this->akcjaOK(null, 'index', $par) ) {
			//jeżeli ta akcja nie jest dozwolona przekieruj na inną dozwoloną
			switch($this->Auth->user('OX')) {
				case IDX_ALL:
				case IDX_SAL:
					return $this->redirect( array('action' => 'index') );
					break;
				case IDX_NO_PRIV:
					return $this->redirect( array('action' => 'index', 'all-but-priv') );
					break;
				case IDX_NO_KOR:
					return $this->redirect( array('action' => 'index', 'no-priv-no-kor') );
					break;
				case IDX_OWN:
					return $this->redirect( array('action' => 'index', 'my') );
					break;
				default:
					$this->Session->setFlash('NIE MOŻNA WYŚWIETLIĆ LUB NIE MASZ UPRAWNIEŃ.');
					return $this->redirect($this->referer());
					break;
			}
		}
		
		$opcje = array();
		
		switch($par) {
			case 'all-but-priv':
				$opcje = array('OR' => array(
    					'Order.user_id' => $this->Auth->user('id'),
    					'Order.status !=' => PRIV
					));
				break;
			case 'my':
				$opcje = array('Order.user_id' => $this->Auth->user('id'));
			break;
			case 'accepted':
				$opcje = array('Order.status' => O_ACC);
			break;
			case 'rejected':
				$opcje = array('Order.status' => array(O_REJ, W4UZUP));
			break;
			case 'wait4check':
				$opcje = array('Order.status' => array(NOWKA, FIXED, UZUPED));
			break;
			case 'active':
				//$opcje = array('Order.status  !=' => array(KONEC, PRIV));
				
				
				$opcje = array('OR' => array(
						
						array('Order.user_id' => $this->Auth->user('id'), 'Order.status !=' => KONEC ),
						array('Order.status  !=' => array(KONEC, PRIV))
				));
			break;
			case 'closed':
				$opcje = array('Order.status' => KONEC);
			break;
			case 'today': //zmieniamy DZIŚ+, czyli na dziś i przeterminowane
				$opcje = [
					//'Order.stop_day >' => date('Y-m-d', strtotime('-68 days')), // starsze niż x days
					//NA_DZIS_PLUS
					'Order.stop_day >' => date('Y-m-d', strtotime('-' . NA_DZIS_PLUS . 'days')), // starsze niż x days
					'Order.stop_day <=' => date('Y-m-d'),
					'Order.status !=' => [KONEC, PRIV] // prywatnych też nie chcemy
				];			
				$this->Paginator->settings = array(
        			'order' => array(
            		'Order.stop_day' => 'desc'
        			)
    			);
			break;
			case 'tomorrow':
			break;
			default:
				$opcje = array();
		}
		if( !empty($opcje) ) {
			$ordersx = $this->Paginator->paginate( 'Order', $opcje );			
		} else {
			$ordersx = $this->Paginator->paginate();
		}
		$orders = $this->addJobInfo($ordersx);
		$this->set( compact('orders', 'par' ) );
	}

	/**
	 * Chcemy mieć na liscie powiązania handlowych z produkcyjnymi */
	private function addJobInfo( $in = [] ) {

		//$out = $in;
		$i=0;
		foreach( $in as $row) {
			$in[$i]['Order']['ileKart'] = count($row['Card']);
			$in[$i]['Order']['ileJobs'] = 0;
			$in[$i]['Order']['idJoba'] = 0;
			foreach($in[$i]['Card'] as $karta) {
				if( $karta['job_id']) {
					$in[$i]['Order']['ileJobs']++;
					if( $in[$i]['Order']['ileJobs'] == 1 ) { // chcemy nr pierwszego
						$in[$i]['Order']['idJoba'] = $karta['job_id']; // id tego pierwszego
						$job = $this->Order->Card->Job->find('first', [
							'conditions' => ['Job.id' => $karta['job_id']],
							'recursive' => 0
						]);
						$in[$i]['Order']['nrJoba'] = $job['Job']['nr'];
						$in[$i]['The'] = $job;
					}
				}
			}
			$i++;
		}		
		return $in;
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		$options = array(
			'conditions' => array('Order.' . $this->Order->primaryKey => $id),
			//'recursive' => 2 // to jest porażka
		);
		$order = $this->Order->find('first', $options);
                
		if( !$this->akcjaOK($order['Order'], 'view') ) {
			$this->Session->setFlash('NIE MOŻNA WYŚWIETLIĆ LUB NIE MASZ UPRAWNIEŃ.');
			return $this->redirect($this->referer());
		}
		
		$evcontrol = $this->prepareSubmits($order);
		$users = $this->Order->User->find('all', array(
					'fields' => array( 'id','name','k', 'enotif'),
					'recursive' => 0
		));
		
		foreach( $order['Card'] as &$card) {
			if( $card['job_id'] ) {
                            $job = $this->Order->Card->Job->find('first', array(
                                    'conditions' => array('Job.id' => $card['job_id']),
                                    'fields' => array('id', 'nr')
                            ));
                            $card['job_nr'] = $job['Job']['nr'];
			}
			else    {
                            $card['job_nr'] = 0; }
		}
		$vju = $this->Order->get_view_options();
		foreach( $users as $value) {
			$ludz[$value['User']['id']] = array('name'=>$value['User']['name'], 'k'=>$value['User']['k'], 'enotif'=>$value['User']['enotif']);
                }
		//$evtext = $this->evtext2;
                $evtext = $this->Order->eventText;
                
                $this->pdfConfig = array(
                    'margin' => array(
                        'bottom' => 7,
                        'left' => 25,
                        'right' => 7,
                        'top' => 7
                    ),
                    'orientation' => //'landscape', 
                                    'portrait',
                    'filename' => /*'Zamowienie_' . */$this->bnr2nrh2($order['Order']['nr'],$order['User']['inic'],false, '-')
                 );
                
		/* kwestia czy wyświetlać danemu użytkownikowi info o przedpłacie
		* oraz czy można klikać i (co za tym idzie) zmieniać stan zaliczki                 * 
		*/
		$order['Order'] = $this->add_prepaid_data($order['Order']);
		/*
		*  Chcemy móc modyfikować status kart*/
		$order['Order'] = $this->addStatusModCap($order['Order']);

		$dzial = $this->Auth->user('dzial');
		$this->set( compact('order', 'evcontrol', 'users', 'ludz', 'vju', 'evtext', 'dzial') );
		//$this -> render('druknij');
	}
		/*
		* Dodanie możliwości modyfikacji statusu karty dla niektórych osób */
		private function addStatusModCap( $order_arr = array() ) {

			if( in_array( $this->Auth->user('dzial'), [SUA, KOR] ) ) { // uprawnione działy
				$order_arr['statusKartyMoznaModyfikowac'] = true;
			} else {
				$order_arr['statusKartyMoznaModyfikowac'] = false;
			}
			return $order_arr;
		}

        // czy wyświetlać danemu użytkownikowi czy dany użytkownik,
        // któremu się wyświetla handlowe, może klikać w zaliczkę
        private function add_prepaid_data( $order_arr = array()) {
            
            $order_arr['zal_clickable'] = $this->is_prepaid_clickable($order_arr['status']);
            // superadmin, handlowcy, koordynator i sekretarka potrzebują przedpłaty
            if( $this->Auth->user('dzial') <= KOR ||  $this->Auth->user('dzial') == SEK ) {
                $order_arr['zal_visible'] = true;
            } else {
                $order_arr['zal_visible'] = false;
            }
            return $order_arr;
        }
        
        private function is_prepaid_clickable( $status = null ) { 
            return 
                ($this->Auth->user('dzial') <= KOR) && // odpowiedni uzytkownik
                $status != PRIV && $status != KONEC; // odpowiedni status zamówienia
            
        }
        
 /*
 *      Ajax - sprawdzanie kwestii płatności
 */
        
        public function prepaid() {
            
            $result = $this->Order->prepaidStatus($this->request->data['id']);
            $answer = $result['Order'];
            //$answer['stan_zaliczki'] = 'money'; // dla testow
            $answer['jest_zaliczka'] = $answer['forma_zaliczki'] > 1;
            $answer['clickable'] = $this->is_prepaid_clickable($answer['status']);            
            
            $this->set(array(
                'answer' => $answer,
                '_serialize' => 'answer' //to używamy, gdy nie chcemy view
            ));
            //sleep(1);
	
        }
/*
 *      Ajax - Ustaw nowy stan zaliczki
 */        
        public function setPrePaidState() {
            
            $zwrotka = $this->Order->setPrepaidStatus($this->request->data);            
            $this->set(array(
                'zwrotka' => $zwrotka,
                '_serialize' => 'zwrotka' //to używamy, gdy nie chcemy view
            ));
            //sleep(3);
        }
	//Sprawdza czy karta ma perso (tak konserwatywnie na wszelki wypadek)
	private function hasPerso( $card ) {
		return $card['isperso'] || $card['pl'] || $card['pt'] || $card['pe'];
	}

	public function prepareSubmits($order) {
		
            $tab = array(
                'buttons' => array(publi, kor_ok, kor_no, fix_o, put_kom, send_o, unlock_o, update_o, klepnij, unlock_again, push4checking, odemknij),
                'bcontr' => array(publi=>0, kor_ok=>0, kor_no=>0, fix_o=>0, put_kom=>0, send_o=>0, unlock_o=>0, update_o=>0, unlock_again=>0, klepnij=>0, push4checking=>0, odemknij=>0),
                'ile' => 0 //liczba submitow do wyświetlenia
            );


            $tworca = $order['Order']['user_id'] == $this->Auth->user('id');
            /**/
            $karty_sprawdzone = $no_rej_card = true;
			$persoIsFinished = true; // Karta nie ma perso lub ma i jest ono zakończone 
            foreach ($order['Card'] as $card)	{
                    if( $card['status'] != D_OK && $card['status'] != P_OK ) $karty_sprawdzone = false;	
                    if( in_array( $card['status'], array(W4DPNO, W4PDNO, DNO, DOKPNO, DNOPNO, DNOPOK)) ) {
                    // jeżeli choć jedna karta jest "odrzucona"
                            $no_rej_card = false;
					}
					//Jezeli karta ma perso i nie jest zakonczona
					if( $this->hasPerso($card) && !$card['pover'] ) { $persoIsFinished = false;  }
            }


            switch( $order['Order']['status'] ) {
                    case PRIV:
                            $tab = $this->plant_PUBLIKUJ($tab, $tworca); // przycisk "PUBLIKUJ"
                    break;
                    case NOWKA:
                    case FIXED:
                            $tab = $this->plant_KOMENTUJ($tab, $tworca); // przycisk "KOMENTARZ"
                            $tab = $this->plant_KOORDYNACJA($tab, $karty_sprawdzone); // przyciski "kor_ok1" i "kor_no1"				
                    break;
                    case O_ERR:
                    case O_FINE:
                            $tab = $this->plant_KOMENTUJ($tab, $tworca); // przycisk "KOMENTARZ"
                    break;
                    case O_REJ:
                            $tab = $this->plant_KOMENTUJ($tab, $tworca); // przycisk "KOMENTARZ"
                            $tab = $this->plant_FIX_O2($tab, $tworca, fix_o); // przycisk "POPRAW" fix_o1
                    break;
                    case O_ACC:
                            $tab = $this->plant_KOMENTUJ($tab, $tworca); // przycisk "KOMENTARZ"				
							// Poprawka, by nie można zamknąć, jezeli perso nie jest zamknięte
							/* Jezeli karta ma perso i nie jest zakonczona, to nie mozna zamknac */
							if( $persoIsFinished ) {
								$tab = $this->plant_WYSLANE($tab, $tworca); // przycisk "WYSŁANE"
							}                            
                            $tab = $this->plant_ODBLOKUJ($tab, $tworca); // przycisk "ODBLOKUJ"
                    break;
                    case W4UZUP:
                    case UZU_REJ:
                            $tab = $this->plant_KOMENTUJ($tab, $tworca); // przycisk "KOMENTARZ"
                            $tab = $this->plant_UPDATE($tab, $tworca); // przycisk "UZUPEŁNIONE"
                    break;											// dla handlowca
                    case UZUPED:
                            $tab = $this->plant_KOMENTUJ($tab, $tworca);
                            $tab = $this->plant_DEALWITHUZUPED($tab, $tworca, $no_rej_card);
                    break;
                    case UZU_CHECK:
                            $tab = $this->plant_KOMENTUJ($tab, $tworca);
                    case KONEC: // gdy zamknięte chemy miec możliwość otwarcia
                            $tab = $this->plant_OTWORZ($tab);                     
                    break;
            }

            return $tab;
		
	}
	
	private function plant_PUBLIKUJ( $button_tab = array(), $tworca = false ) {
			
			$ret_tab = $button_tab;
			
			switch( $this->Auth->user('O_PUB') ) { // sprawdzamy uprawnienia do publikowania zamówień
					case r_OWN:
						if( $tworca ) {
							$ret_tab['bcontr'][publi] = 1;
							$ret_tab['ile']++;
						}
					break;
					case r_ALL:
					case r_SAL:
						$ret_tab['bcontr'][publi] = 1;
						$ret_tab['ile']++;
					break;
			}
			
			return $ret_tab;
		}

	private function plant_FIX_O( $button_tab = array(), $tworca = false, $indeks = null ) {
			
		if( $indeks != null ) { 
			$ret_tab = $button_tab;
		
			switch( $this->Auth->user('O_PUB') ) { // sprawdzamy uprawnienia do publikowania zamówień
				case r_OWN:
					if( $tworca ) {
						$ret_tab['bcontr'][$indeks] = 1;
						$ret_tab['ile']++;
					}
				break;
				case r_ALL:
				case r_SAL:
					$ret_tab['bcontr'][$indeks] = 1;
					$ret_tab['ile']++;
				break;
			}
			return $ret_tab;
		}
		return $button_tab;
	}

	private function plant_FIX_O2( $button_tab = array(), $tworca = false, $indeks = null ) {
			
			if( $indeks != null ) { 
				$ret_tab = $button_tab;
			
				switch( $this->Auth->user('O_PUB') ) { // sprawdzamy uprawnienia do publikowania zamówień
					case r_OWN:
						if( $tworca ) {
							$ret_tab['bcontr'][$indeks] = 1;
							$ret_tab['ile']++;
						}
					break;
					case r_ALL:
					case r_SAL:
						$ret_tab['bcontr'][$indeks] = 1;
						$ret_tab['ile']++;
					break;
				}
				return $ret_tab;
			}
			return $button_tab;
	}

	private function plant_KOMENTUJ( $button_tab = array(), $tworca = false ) {
			
			$ret_tab = $button_tab;
			
			switch( $this->Auth->user('O_KOM') ) { // uprawnienia do komentowania
					case r_OWN:
						if( $tworca ) {
							$ret_tab['bcontr'][put_kom] = 1;
							$ret_tab['ile']++;
						}
					break;
					case r_ALL:
					case r_SAL:
						$ret_tab['bcontr'][put_kom] = 1;
						$ret_tab['ile']++;
					break;
				}
			
			return $ret_tab;
	}
	
	private function plant_WYSLANE( $button_tab = array(), $tworca = false ) {
		
		$ret_tab = $button_tab;
		
		switch( $this->Auth->user('O_SEN') ) {
			case r_ALL:
			case r_SAL:
				$ret_tab['bcontr'][send_o] = 1;
				$ret_tab['ile']++;
			break;
		}
		return $ret_tab;
	}
        
        private function plant_OTWORZ( $button_tab = array(), $tworca = false ) {
		
		$ret_tab = $button_tab;
		// superadmin, kordynator lub krysia                
                $properDzial = in_array($this->Auth->user('dzial'), array(SUA, KOR, SEK));
                if( $properDzial ) {
                    $ret_tab['bcontr'][odemknij] = 1;
                    $ret_tab['ile']++;
                }		
		return $ret_tab;
	}
		
	private function plant_KOORDYNACJA( $button_tab = array(), $karty_ok = false ) {
			
		
			$ret_tab = $button_tab;
			switch( $this->Auth->user('O_KOR') ) { // uprawnienia do działań koordynacyjnych
				case r_ALL:
				case r_SAL:
					$ret_tab['bcontr'][kor_ok] = 1;
					$ret_tab['bcontr'][kor_no] = 1;						
					$ret_tab['ile'] = $ret_tab['ile'] + 2;
				break;
			}
			return $ret_tab;
	}

	private function plant_ODBLOKUJ( $button_tab = array(), $karty_ok = false ) {			
		
            $ret_tab = $button_tab;
            switch( $this->Auth->user('O_KOR')  
                    // || $this->Auth->user('dzial') == KIP // panią Becię wyłączamy
                    ) { 
                    // uprawnienia do działań koordynacyjnych + dla pani Beci
                    case r_ALL:
                    case r_SAL:
                            $ret_tab['bcontr'][unlock_o] = 1;
                            $ret_tab['ile']++;
                    break;
            }
            return $ret_tab;
	}
	
	private function plant_UPDATE( $button_tab = array(), $tworca = false ) {
		
		$ret_tab = $button_tab;
		
		switch( $this->Auth->user('O_PUB') ) { // uprawnienia publikowania zamówień
			case r_OWN:
                            if( $tworca ) {
                                    $ret_tab['bcontr'][update_o] = 1;
                                    $ret_tab['ile']++; }
                            break;
			case r_ALL:
			case r_SAL:
				$ret_tab['bcontr'][update_o] = 1;
				$ret_tab['ile']++;
			break;
		}
		
		return $ret_tab;
	}

	private function plant_DEALWITHUZUPED( $button_tab = array(), $tworca = false, $norejcard = true ) {
		
		$ret_tab = $button_tab;
		switch( $this->Auth->user('O_KOR') 
                        // || $this->Auth->user('dzial') == KIP // panią Becię wyłączamy
                        ) { 
			// uprawnienia do działań koordynacyjnych +ukłon dla pani Beci
				case r_ALL:
				case r_SAL:
					$ret_tab['bcontr'][unlock_again] = 1;
					$ret_tab['bcontr'][push4checking] = 1;
					$ret_tab['ile'] = $ret_tab['ile'] + 2;
					if( $norejcard ) {
						$ret_tab['bcontr'][klepnij] = 1;	
						$ret_tab['ile'] = $ret_tab['ile'] + 1;
					}
					
				break;
			}
		return $ret_tab;
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		if ($this->request->is('post')) {			
			
			$this->request->data = $this->Order->cleanData($this->request->data);
			if( empty($this->request->data['Card']) )
			  $this->Session->setFlash('NIE WYBRAŁEŚ ŻADNEJ KARTY!');
			else {
				//$this->Order->print_r2( $this->Order->saveItAll($this->request->data) ); return;
				if ($this->Order->saveItAll($this->request->data)) {
					$this->Session->setFlash('Zamówienie zostało zapisane.', 'default', array('class' => GOOD_FLASH));
					//return $this->redirect(array('action' => 'index'));
                                        return $this->redirect(array('action' => 'view', $this->Order->id));
				} else {
					$blad = $this->Order->siaErr;
					$this->Session->setFlash( 'Nie można zapisać zamówienia. Proszę, spróbuj ponownie: ' . $blad );
				}
				
			}
		}
		$vju = $this->Order->get_view_options();
		$tedane = $this->Order->getTheCardsAndRelated($this->Auth->user('id'));
		if( empty($tedane) ) //nie ma 'nie podpiętych' kart
		{
			$this->Session->setFlash(__('Musisz najpierw dodać jakąś kartę!'));
			return $this->redirect( array(
					'controller' => 'cards', 'action' => 'index'
			));
		}
		
		$this->set(compact( 'vju', 'tedane' ));
		
	}

/**
 * add2 method
 *
 * @return void
 */
public function add2() {
		
	if ($this->request->is('post')) {
		/*
		$this->Order->print_r2($this->request->data);
		
		$this->request->data = $this->Order->cleanData($this->request->data);
		$this->Order->print_r2($this->request->data);
		return;
		*/
		
		$this->request->data = $this->Order->cleanData($this->request->data);
		if( empty($this->request->data['Card']) )
		  $this->Session->setFlash(__('NIE WYBRAŁEŚ ŻADNEJ KARTY!'));
		else {
			//$this->Order->print_r2( $this->Order->saveItAll($this->request->data) );
			//return;
			if ($this->Order->saveItAll($this->request->data)) {
				$this->Session->setFlash('Zamówienie zostało zapisane.', 'default', array('class' => GOOD_FLASH));
				//return $this->redirect(array('action' => 'index'));
									return $this->redirect(array('action' => 'view', $this->Order->id));
			} else {
				$blad = $this->Order->siaErr;
				$this->Session->setFlash(__('Nie można zapisać zamówienia. Proszę, spróbuj ponownie: '.$blad));
			}
			
		}
			//$this->Order->print_r2($this->request->data);
		
		
	}
	$vju = $this->Order->get_view_options();
	$tedane = $this->Order->getTheCardsAndRelated($this->Auth->user('id'));
	if( empty($tedane) ) //nie ma 'nie podpiętych' kart
	{
		$this->Session->setFlash(__('Musisz najpierw dodać jakąś kartę!'));
		return $this->redirect( array(
				'controller' => 'cards', 'action' => 'index'
		));
	}
	
	$this->set(compact( 'vju', 'tedane' ));
	
}



/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		
		if (!$this->Order->exists($id)) {
			throw new NotFoundException("Zlecenie id={$id} nie istnieje");
		}
		
		if ($this->request->is(array('post', 'put'))) {
			
			//$this->Order->print_r2($this->request->data);		

			if ( $this->Order->editItAll($this->request->data) ) {
				$this->Session->setFlash( $this->Order->succMsg, 'default', array('class' => GOOD_FLASH));
				//return $this->redirect(array('action' => 'index'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
                $this->Session->setFlash( 'Nie udało się zapisać zamówienia. Sprubój ponownie.' . ' eiaErr = ' . $this->Order->eiaErr );
			}
		} else {
				$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
				$dt = $this->Order->find('first', $options);
				
				if( $this->akcjaOK($dt['Order'], 'edit') )	{					
					unset($dt['User']['password']); // nie chcemy przesylać hasla nawet zahaszowanego
					if( $dt['Order']['sposob_dostawy'] != IA ) //inny adres nie jest potrzebny
						unset($dt['AdresDostawy']);
			
			
					$karty = $this->Order->Card->find('all', array(
						'conditions' => array(	'Card.owner_id' => $dt['Customer']['owner_id'],
									'Card.order_id' => 0,
									'Card.customer_id' => $dt['Customer']['id']
									),
						'fields' => array(	'Card.id', 'Card.name', 'Card.quantity', 'Card.ilosc',
									'Card.mnoznik', 'Card.price',
									'Card.customer_id', 'Card.order_id',
									'Customer.id', 'Customer.name', 'Customer.forma_zaliczki',
									'Customer.procent_zaliczki', 'Customer.forma_platnosci',
									'Customer.termin_platnosci', 'Customer.osoba_kontaktowa',
									'Customer.tel'),
				
						'recursive' => 0
					));
			
					foreach ($karty as $value) {
						array_push( $dt['Card'], $value['Card'] );
					}
					$this->request->data = $dt;
				} else {
					$this->Session->setFlash('EDYCJA NIE JEST MOŻLIWA LUB NIE MASZ UPRAWNIEŃ.');
					return $this->redirect($this->referer());
					//return $this->redirect(array('action' => 'index'));
				}
			}
			$users = $this->Order->User->find('list');
			$customers = $this->Order->Customer->find('list');
			$vju = $this->Order->get_view_options(true);
			$test = $this->request->data['Order'];	
			/* Jeżeli zamówienie wygenerowane autoamtycznie,
			to mamy do czynieia z pierwszą edycją */
			if( !$this->request->data['Order']['auto'] ) {
				unset($vju['newcustomer']['options'][null]);
				if( $this->request->data['Order']['newcustomer'] ) {
					$vju['newcustomer']['default'] = true;
				} else {
					$vju['newcustomer']['default'] = false;
				}	
			}					
			$this->set(compact('users', 'customers', 'vju', 'karty', 'dt', 'test'));
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid order'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Order->delete()) {
			$this->Session->setFlash(__('The order has been deleted.'));
		} else {
			$this->Session->setFlash(__('The order could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	// sprawdzamy uprawnienia dla akcji w tym kontrolerze
	private function akcjaOK( $dane = array(), $akcja = null, $par = null ) {
	
		switch($akcja) {
					case 'edit':
						$order = $dane; // dawne poniżej: $order['status'] == PRIV ||  $order['status'] == O_REJ
						if( $this->Auth->user('OE') == EDIT_SAL || in_array($order['status'], array(PRIV, O_REJ, W4UZUP, UZU_REJ)) ) { //stan zamówienia pozawla na edycję
							switch( $this->Auth->user('OE') ) {
								case NO_RIGHT:
									return false;
								case EDIT_OWN:
									if( $this->Auth->user('id') == $order['user_id'] )
										return true;
									else
										return false;
								case EDIT_SHR:
									return false;
								case EDIT_ALL:
								case EDIT_SAL:
									return true;
							}							
						} 
						break;
					case 'view':
						$order = $dane;
						if( $this->Auth->user('id') == $order['user_id'] )
							$jego_zamowienie = true;
						else
							$jego_zamowienie = false;
						if( 1 ) {//jeżeli nie ma przeszkód, nie związanych z uprawnieniami, do wyświetlenia
							switch( $this->Auth->user('OV') ) {
								case VIEW_SAL:
								case VIEW_ALL:
									return true;
									break;
								case VIEW_NO_PRIV: //nie może prywatnych zamówień innych ludzi oglądać
									if( $jego_zamowienie || ( $order['status'] != PRIV ) )
										return true;
									else
										return false;
									break;	
								/*
								case VIEW_NO_KOR: // jak NO_PRIV + to co na pocz dla koordynatora
									if( !in_array($order['status'], array( PRIV, NOWKA, KREJ1, FIXED1 ) ) )
										return true;
								break;	
								*/						
								case NO_RIGHT:
								case VIEW_SHR:
									return false;
									break;
								case VIEW_OWN:
									return $jego_zamowienie;
									break;
							}
							
						}
					break;
					case 'index':
						$upraw = $this->Auth->user('OX');
						switch($par) {
							case null:
								if( $upraw == IDX_ALL || $upraw == IDX_SAL ) return true;
								break;
							case 'all-but-priv':
								if( $upraw == IDX_NO_PRIV || $upraw == IDX_ALL || $upraw == IDX_SAL) return true;
								break;
							case 'no-priv-no-kor':
								switch($upraw) {
									case IDX_NO_KOR: case IDX_NO_PRIV: case IDX_ALL: case IDX_SAL:
									return true;
									break;
								}
							break;
							case 'my':
								return true;
							break;
							default:
								return true;
						}
						break;
		}
		return false;
		
	}


}
