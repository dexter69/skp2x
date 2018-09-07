<?php
App::uses('AppController', 'Controller');
/**
 * Customers Controller
 *
 * @property Customer $Customer
 * @property PaginatorComponent $Paginator
 */
class CustomersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $helpers = array('BootHtml', 'BootForm', 'Math');
	
	
	public function beforeFilter() {
    	parent::beforeFilter();
    	//$this->actionAllowed();
	}

/**
 * index methods
 *
 * @return void
 */

	public function index($par = null) {
		
		$this->Customer->recursive = 0;
		
		if( !$this->akcjaOK(null, 'index', $par) ) {
			//jeżeli ta akcja nie jest dozwolona przekieruj na inną dozwoloną
			switch($this->Auth->user('CX')) {
				case IDX_ALL:
				case IDX_SAL:
					return $this->redirect( array('action' => 'index') );
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
		
		switch($par) {
			case null:
				$customers = $this->Paginator->paginate();
				break;
			case 'my':
				$customers = $this->Paginator->paginate(
					'Customer',
					array('Customer.user_id' => $this->Auth->user('id'))
				);
				break;
		}
		
		$links = $this->links; 
		$this->set( compact('customers', 'links' ) );
		
	}
        
/**
 * active method - w celach statystycznych - szukamy klientów, którzy coś zamówili w 2015
 *
 * @throws NotFoundException
 * * @return void
 */
        
        public function active() {
         
            $klienci = $this->Customer->aktywni2015();
            // cokolwiek zamówili
            //$klienci = $this->Customer->aktywni();
            $this->set( compact( 'klienci') );
        }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            if (!$this->Customer->exists($id)) {
                    throw new NotFoundException( 'Invalid customer' );
            }	            
            $customer = $this->Customer->customerRelated($id);
            if( !$this->akcjaOK($customer['Customer'], 'view') ) {
                    $this->Session->setFlash('NIE MOŻNA WYŚWIETLIĆ LUB NIE MASZ UPRAWNIEŃ.');
                    return $this->redirect($this->referer());
            }
            $customer['Customer']['etylang-txt'] = $this->Customer->etyk_view['etylang']['cview'][$customer['Customer']['etylang']];
            $this->set( compact( 'customer') );
            //$this->render('view-old'); 
	}        
        
/**
 * dodaj method --------> dodawanie klienta po nowemu 
 */
        public function dodaj() {

                $request = [];
                if ($this->request->is('post')) {
                        //$request = $this->request->data;
                        // zrób coś z przesłanymi danymi
                        
                        // test błędu
                        //$this->Session->setFlash('Bla, bla - jakiś błąd.');                        

                        //Testujemy walidację w kontrolerze
                        $this->Customer->set($this->request->data);
                        if ($this->Customer->validates()) {
                                // it validated logic
                                $request = $this->request->data;
                            } else {
                                // didn't validate logic
                                $request = $this->Customer->validationErrors;                                
                            }
                }
                if( $this->Auth->user('dzial') == KON ) {
                        //kontrola jakości - przekieruj skąd przyszli 
                        return $this->redirect($this->referer());
                }
                // opcje wyświetlania pól zdefiniowane w modelu
                $vju = $this->Customer->boot_view_options;
                $this->set( compact('vju', 'request') );
                //$this->render('dodaj');                
        }

/**
 * add method
 *
 * @return void
 * 
 * echo $this->Html->link($customer['Owner']['name'], array('controller' => 'users', 'action' => 'view', $customer['Owner']['id'])); 
 * 
 */
	public function add() {
		
            if ($this->request->is('post')) {
                    $this->request->data['Customer']['user_id'] = $this->Auth->user('id');
                    // stały opiekun -> ten kto dodaje, staje się stałym opiekunem
                    $this->request->data['Customer']['opiekun_id'] = $this->Auth->user('id');
                    $this->request->data['AdresSiedziby']['user_id'] = $this->Auth->user('id');
                    //$this->Customer->print_r2($this->request->data);  return;

                    $caseNR = $this->Customer->validateNIP( $this->request->data );                    
                    //echo '<pre>'; print_r($caseNR); echo  '</pre>'; return;
                    //echo $mth; return;

                    switch( $caseNR ) { // egzaminujemy rezultat sprawdzania NIP'u
                        case 0: //wsio OK
                                $this->Customer->create();
                                if ($this->Customer->saveAssociated($this->request->data)) {                                
                                        return $this->redirect(array('action' => 'view', $this->Customer->id));
                                } else {					
                                        $this->Session->setFlash( ('Nie udało się zapisać. Proszę, spróbuj ponownie.') );
                                }
                                break;
                        case 1: // nieprawidłowy format
                                $this->Session->setFlash( ('Wpisany NIP ma nieprawidłowy format!') );
                                break;
                        case 2: // taki nip już istnieje
                                $name = $this->request->data['result']['Customer']['name'];
                                $cuid = $this->request->data['result']['Customer']['id'];
                                $url = Router::url(array('controller'=>'customers', 'action'=>'view', $cuid));
                                $this->Session->setFlash('Klient z tym numerem NIP-u już istnieje <a href="' . $url . '">' . $name . '</a>');
                                break;
                        default:
                                $this->Session->setFlash('Nieznany błąd. Zapytaj Darka, jeżeli tu jeszcze pracuje.');
                    }
            }
            if( $this->Auth->user('dzial') == KON ) {
                //kontrola jakości - przekieruj skąd przyszli 
                return $this->redirect($this->referer());
            }
            // opcje wyświetlania pól zdefiniowane w modelu
            $vju = $this->Customer->get_view_options();
            //$this->set(compact('vju'));

            $links = $this->links; 
            $this->set( compact('vju', 'links' ) );
            $this->render('add-old');
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Customer->exists($id)) {
			throw new NotFoundException('Nie mogę znaleźć takiego klienta');
		}
		if ($this->request->is(array('post', 'put'))) {
                    // coby ewentualnie zmienić opiekuna
                    $this->request->data['Customer']['owner_id'] = $this->request->data['Customer']['user_id'];
                    //$this->Customer->print_r2($this->request->data); //return;

                    $caseNR = $this->Customer->validateNIP( $this->request->data );                                        
                    switch( $caseNR ) { // egzaminujemy rezultat sprawdzania NIP'u
                        case 0: //wsio OK
                                if ($this->Customer->saveAssociated($this->request->data)) {                                
                                        return $this->redirect(array('action' => 'view', $this->Customer->id));
                                } else {					
                                        $this->Session->setFlash( ('Nie udało się zapisać. Proszę, spróbuj ponownie.') );
                                }
                                break;
                        case 1: // nieprawidłowy format NIP'u
                                $this->Session->setFlash( ('Wpisany NIP ma nieprawidłowy format!') );
                                break;
                        case 2: // taki nip już istnieje
                                $name = $this->request->data['result']['Customer']['name'];
                                $cuid = $this->request->data['result']['Customer']['id'];
                                $url = Router::url(array('controller'=>'customers', 'action'=>'view', $cuid));
                                $this->Session->setFlash('Klient z tym numerem NIP-u już istnieje <a href="' . $url . '">' . $name . '</a>');
                                break;
                        default:
                                $this->Session->setFlash('Nieznany błąd. Zapytaj Darka, jeżeli tu jeszcze pracuje.');
                    }

		} else {
			$options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
			$this->request->data = $this->Customer->find('first', $options);
			if( !$this->akcjaOK($this->request->data['Customer'], 'edit') )	{	
				$this->Session->setFlash('EDYCJA NIE JEST MOŻLIWA LUB NIE MASZ UPRAWNIEŃ.');
				return $this->redirect($this->referer());
			}
		}		
                
                // użytkownicy, coby opiekuna mozna zmienić
		$users = $this->Customer->Creator->find('list', array(
                    'conditions' => array('dzial <' => 3, 'id !=' => [1,4,28]) //darek, Jola, Agnieszka - dummy
                ));
		$vju = $this->Customer->get_view_options($this->request->data['Customer']);
		$links = $this->links;
		$this->set(compact('users','vju', 'links'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid customer'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Customer->delete()) {
			$this->Session->setFlash(__('The customer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The customer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	private function akcjaOK( $dane = array(), $akcja = null, $par = null ) {
		
		switch($akcja) {
                    case 'view':
                            $customer = $dane;
                            switch( $this->Auth->user('CV') ) {
                                    case VIEW_OWN:
                                            if( $this->Auth->user('id') == $customer['user_id'] ) return true;
                                            break;
                                    case VIEW_ALL:
                                    case VIEW_SAL:
                                            return true;
                                            break;
                            }
                            break;
                    case 'edit':
                                    $customer = $dane;
                                    switch( $this->Auth->user('CE') ) {
                                            case EDIT_OWN:
                                                    if( $this->Auth->user('id') == $customer['user_id'] ) return true;
                                                    break;
                                            case EDIT_ALL:
                                            case EDIT_SAL:
                                                    return true;
                                                    break;
                                    }							
                                    return false;
                                    break;
                    case 'index':
                                    $upraw = $this->Auth->user('CX');
                                    switch($par) {
                                            case null:
                                                    if( $upraw == IDX_ALL || $upraw == IDX_SAL ) return true;
                                                    break;
                                            case 'my':
                                                    switch($upraw) {
                                                            case IDX_OWN: case IDX_ALL: case IDX_SAL:
                                                            return true;
                                                            break;
                                                    }
                                                    break;
                                    }
                                    break;
		}
		return false;
	}
	
	
	
}
