<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Events Controller
 *
 * @property Event $Event
 * @property PaginatorComponent $Paginator
 */
class EventsController extends AppController {

/**
 *  Coby obejść ograniczenie 10 maili/ 5 minut w home.pl
 *
 * 
 */
        
        private $smtp_index = 0;

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Event->recursive = 0;
		$this->set('events', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$this->set('event', $this->Event->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			//if( $this->request->data['Event'] )
			//$this->Event->create();
			
			$sbstr = substr($this->request->data['Event']['post'], 0, 2);								
			if( $sbstr  == '#!' ||  $sbstr == '!#' || $sbstr  == '!@' ||  $sbstr == '@!' ) {
				$this->Event->print_r2($this->request->data);
				//$this->request->data = $this->Event->prepareData($this->request->data, false);
				$this->Event->print_r2($this->Event->prepareData($this->request->data, false));
				return;
			}
			$oid = $this->request->data['Event']['order_id'];
			$jid = $this->request->data['Event']['job_id'];
			//if ($this->Event->save($this->request->data)) {
			if ( $this->Event->prepareData($this->request->data, true) ) {
					
                            if( $oid ) {
                                $xyz=$this->e_powiadamiaj($this->request->data['Event']);
                                //echo '<pre>'; $this->Event->print_r2($xyz); echo '</pre>';
                                //return;
                                switch( $this->request->data['Event']['co'] ) {
                                    case p_ov:
                                        // zakończenie perso -> tak chciał Adam
                                        return $this->redirect(array('controller' => 'cards', 'action' => 'index', 'ptodo' ));
                                    case p_no:
                                    case p_ok:
                                        return $this->redirect(array('controller' => 'cards', 'action' => 'index', 'persocheck' ));
                                    default:
                                        return $this->redirect(array('controller' => 'orders', 'action' => 'view', $oid ));
                                }
                                
                            } else
                                if( $jid ) {
                                    $xyz=$this->e_powiadamiaj($this->request->data['Event']);
                                    //echo '<pre>'; $this->Event->print_r2($xyz); echo '</pre>';
                                    //return;
                                    //return $this->redirect(array('controller' => 'jobs', 'action' => 'index'));
                                    return $this->redirect(array('controller' => 'jobs', 'action' => 'view', $jid));
                                } else
                                    { return $this->redirect(array('controller' => 'orders', 'action' => 'index')); }
						
			} else {
				if( $this->Event->code != 777) {
                                $this->Session->setFlash('BŁĄD ('. $this->Event->code .')'); }
				else {
                                    $this->Session->setFlash( $this->Event->msg ); }
				return $this->redirect($this->referer());
			}
		}
		return $this->redirect($this->referer());
		/*
		$users = $this->Event->User->find('list');
		$orders = $this->Event->Order->find('list');
		$jobs = $this->Event->Job->find('list');
		$cards = $this->Event->Card->find('list');
		$this->set(compact('users', 'orders', 'jobs', 'cards'));
		*/
	}

	
	private function e_powiadamiaj( $eventtab = array()) {
		
		if( !empty($eventtab) ) {
			if( $eventtab['order_id'] ) {
				$value = $this->Event->Order->find('first', array(
					'conditions' => array('Order.id' => $eventtab['order_id'])
				));
				$temat = 'ZAM ' .
                                    $this->bnr2nrh2($value['Order']['nr'],$value['User']['inic'],false);
				$linktab = array('controller' => 'orders', 'action' => 'view', $eventtab['order_id']);
			} else {
				$value = $this->Event->Job->find('first', array(
					'conditions' => array('Job.id' => $eventtab['job_id'])
				));
				$temat = 'ZLE ' .
						$this->bnr2nrj2($value['Job']['nr'],$value['User']['inic'],false);
				$linktab = array('controller' => 'jobs', 'action' => 'view', $eventtab['job_id']);
			}
			$theEvent = end($value['Event']);
			$temat .=	', ' . $this->Auth->user('name'). ' ' .
						$this->evtext2[$eventtab['co']][$this->Auth->user('k')];
						
			if($eventtab['card_id'])	{
					if( $eventtab['co'] == put_kom ) $temat .= ' odnośnie karty:';
					foreach( $value['Card'] as $karta )
						if( $karta['id'] == $eventtab['card_id'] )
							$temat .= ' ' . $karta['name'];
			}
			
			$tresc = $eventtab['post'];
			
			foreach( $value['Event'] as $ewent ) {
				$uids[$ewent['user_id']] = 1; //przypisz na razie cokolwiek	
                        }
			if( $eventtab['job_id'] ) { //zlecenie, trza też handlowcom wyslac
				foreach( $value['Card'] as $karta )
					$uids[$karta['user_id']] = 1; //przypisz na razie cokolwiek					
			}
			$uids[4] = 1; // Jola zawsze dostaje			
			unset($uids[$this->Auth->user('id')]); // generujący zdarzenie nie dostaje maila
			//$uids[1] = 1; // Darek zawsze dostaje, nawet jak sam napisze                        
			
			foreach( $uids as $key => $wartosc) $tab[] = $key;
			
			$ludziki = $this->Event->User->find('all', array(
                                'conditions' => array('User.id' => $tab),
                                'recursive' => 0
			));
			$odbiorcy = array();
			foreach( $ludziki as $ludz) {
				if( $ludz['User']['enotif'] != null )
					$odbiorcy[] = $ludz['User']['enotif'];
                        }
			if( $eventtab['co'] == p_ov ) { 
                        // w wypadku zakończenia perso, dodatkowo dostaje Krysia
                            $odbiorcy[] = 'info@polskiekarty.pl';
                        }
                        // Frank nie chce tych powiadomień...
                        if( $eventtab['co'] == p_ov || $eventtab['co'] == send_o ) {
                            $klucz = array_search('grafik@polskiekarty.pl',  $odbiorcy);
                            if( $klucz != false ) {
                                unset( $odbiorcy[$klucz] );
                            }
                        }
			$this->piknij($odbiorcy, $temat, $tresc, $linktab, $theEvent['id']);
			
			return true;
		}
		return false;
	}
        
        
        private function piknij( $odbiorcy = array(), $temat = null, $tresc = null, $linktab = array(), $event_id = 0) {
			
            if( !empty($odbiorcy) && $temat != null)	{ //jest komu i co wysłać
                    
                    switch( substr((string)$event_id, -1) ) {
                        case '0':   case '3':   case '6':
                            $email = new CakeEmail('homepl_smtp');
                        break;
                        case '1':   case '4':   case '7':   case '9':
                            $email = new CakeEmail('homepl_smtp1');
                        break;
                        case '2':   case '5':   case '8':
                            $email = new CakeEmail('homepl_smtp2');
                        break;
                        default:
                            $email = new CakeEmail('homepl_smtp');
                    }
                    //if( DEVEL ) {
                    if( DS == WIN) { // We are on Windows!
                        $email->to('darek@polskiekarty.pl');
                    } else
                        { $email->to($odbiorcy); }

                    $email->emailFormat('html');
                    $email->template('eventadd', 'powiadomienia');
                    $email->viewVars(array('linktab' => $linktab));
                    $email->subject($temat);
                    
                    // kontrola na exception, by nie mieć ugly komunikat
                    try { $email->send($tresc); } catch ( Exception $e ) { 
                        $this->Session->setFlash('Powiadomienie e-mailem nie zostało wysłane...');    
                    }
                    
            }
        }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
			$this->request->data = $this->Event->find('first', $options);
		}
		$users = $this->Event->User->find('list');
		$orders = $this->Event->Order->find('list');
		$jobs = $this->Event->Job->find('list');
		$cards = $this->Event->Card->find('list');
		$this->set(compact('users', 'orders', 'jobs', 'cards'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Event->delete()) {
			$this->Session->setFlash(__('The event has been deleted.'));
		} else {
			$this->Session->setFlash(__('The event could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
