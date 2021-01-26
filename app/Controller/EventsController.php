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
                if( $this->displayIT($this->request->data) ) { return; }
                
                if ( $this->Event->prepareData($this->request->data, true) ) {
                    $this->serveEventMailing( $this->request->data );
                } else {
                    $this->serveErr(); 
                }
            }
            return $this->redirect($this->referer());
	}
        
    // w przypadku niepomyślnego zapisania zdarzenia
    private function serveErr() {
    
        if( $this->Event->code != 777) {
            $this->Session->setFlash('BŁĄD ('. $this->Event->code .')'); }
        else {
            $this->Session->setFlash( $this->Event->msg ); }
        return $this->redirect($this->referer());
    }
    
    // $rqdata - $this->request->data
    private function serveEventMailing( $rqdata = array()) {
        
        $oid = $rqdata['Event']['order_id'];
        $jid = $rqdata['Event']['job_id'];
        $arr = array('controller' => 'orders', 'action' => 'index');
        // wyłączamy wysyłanie maili tuatj (e_powidamiaj)
        if( $oid ) {
            //$this->e_powiadamiaj($rqdata['Event']); 
            switch( $rqdata['Event']['co'] ) {
                case p_ov:
                    // zakończenie perso -> tak chciał Adam
                    $arr = array('controller' => 'cards', 'action' => 'index', 'ptodo' ); break;
                case p_no:
                case p_ok:
                    $arr =  array('controller' => 'cards', 'action' => 'index', 'persocheck' ); break;
                default:
                    $arr = array('controller' => 'orders', 'action' => 'view', $oid );
            }
        } else {
            if( $jid ) {
                //$this->e_powiadamiaj($rqdata['Event']);                            
                $arr = array('controller' => 'jobs', 'action' => 'view', $jid);
            } 
        }            
        return $this->redirect($arr);
    }
        
        
        /* Wyświetlamy zawartość tablicy z danymi 
            szukamy charaktarystycznych ciągów znaków w Event['post']
            Jeżeli są obecne, to wyświetlamy info zwracamy true  */
        private function displayIT( $rqdata = array()) {
            
            $sbstr = substr($rqdata['Event']['post'], 0, 2);
            if( $sbstr  == '#!' ||  $sbstr == '!#' || $sbstr  == '!@' ||  $sbstr == '@!' ) {
                    $this->Event->print_r2($rqdata);
                    $this->Event->print_r2($this->Event->prepareData($rqdata, false));
                    return true;
            }
            return false;
        }

	/* przygotuj i wyślij maila do odpowiednich osób */
	private function e_powiadamiaj( $eventtab = array()) {
		
            if( !empty($eventtab) ) {
                    
                // przygotuj temat, treść i link wiadomosci
                $eArr = $this->temTrescLink( $eventtab );
                // przygotuj tablicę z odbiorcami wiadomosci
                $odbiorcy = $this->ludziki( $eArr['value'], $eventtab);                
                $theEvent = end($eArr['value']['Event']);
                $this->piknij($odbiorcy, $eArr['temat'], $eArr['tresc'], $eArr['link'], $theEvent['id']);
                return true;
            }
            return false;
	}
        
        /* Przygotuj tablicę z odbiorcami e-maila */
        private function ludziki( $value = array(), $eventtab = array() ) {
            
            foreach( $value['Event'] as $ewent ) {
                    $uids[$ewent['user_id']] = 1; //przypisz na razie cokolwiek	
            }
            if( $eventtab['job_id'] ) { //zlecenie, trza też handlowcom wyslac
                foreach( $value['Card'] as $karta ) {
                    $uids[$karta['user_id']] = 1; } //przypisz na razie cokolwiek					
            }
            $uids[4] = 1; // Jola zawsze dostaje			
            unset($uids[$this->Auth->user('id')]); // generujący zdarzenie nie dostaje maila
            $uids[1] = 1; // Darek zawsze dostaje, nawet jak sam napisze                        
            $tab = array();
            foreach( $uids as $key => $wartosc) { $tab[] = $key; }

            $ludziki = $this->Event->User->find('all', array(
                    'conditions' => array('User.id' => $tab),
                    'recursive' => 0
            ));
            $odbiorcy = array();
            
            foreach( $ludziki as $ludz) {
                if( $ludz['User']['enotif'] != null ) {
                    $odbiorcy[] = $ludz['User']['enotif']; }
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
            return $odbiorcy;
        }
        
        /* Przygotuj temat, treść i link e-maila */
        private function temTrescLink( $eventtab = array() ) {
            
            if( $eventtab['order_id'] ) { // do handlowego
                $value = $this->Event->Order->find('first', array(
                        'conditions' => array('Order.id' => $eventtab['order_id'])
                ));
                $temat = 'ZAM ' . $this->bnr2nrh2($value['Order']['nr'],$value['User']['inic'],false);
                $linktab = array('controller' => 'orders', 'action' => 'view', $eventtab['order_id']);
            } else { // do produkcyjnego
                $value = $this->Event->Job->find('first', array(
                    'conditions' => array('Job.id' => $eventtab['job_id'])
                ));
                $temat = 'ZLE ' .  $this->bnr2nrj2($value['Job']['nr'],$value['User']['inic'],false);
                $linktab = array('controller' => 'jobs', 'action' => 'view', $eventtab['job_id']);
            }
            //$theEvent = end($value['Event']);
            $temat .=	', ' . $this->Auth->user('name'). ' ' .
                        //$this->evtext2[$eventtab['co']][$this->Auth->user('k')];
                    //po nowemu
                    $this->Event->eventText[$eventtab['co']][$this->Auth->user('k')];

            if($eventtab['card_id'])	{
                if( $eventtab['co'] == put_kom ) { $temat .= ' odnośnie karty:'; }
                foreach( $value['Card'] as $karta ) {
                    if( $karta['id'] == $eventtab['card_id'] ) { $temat .= ' ' . $karta['name']; }
                }
            }            
            return array('temat' => $temat, 'tresc' => $eventtab['post'], 'link' => $linktab,
                         'value' => $value //, 'theEvent' => end($value['Event'])
                );
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
    }


    public function evupdate() {

        $success = false;
        if ( $this->Event->save($this->request->data) ) {
            $success = true;
        } 
        $this->set([
            'answer' => [
                'success' => $success,
                'dostalem' => $this->request->data,
            ],            
            '_serialize' => 'answer' //to używamy, gdy nie chcemy view
        ]);
        //sleep(3);

    }





}
    

    
