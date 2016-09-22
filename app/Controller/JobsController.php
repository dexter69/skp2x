 <?php
App::uses('AppController', 'Controller');
/**
 * Jobs Controller
 *
 * @property Job $Job
 * @property PaginatorComponent $Paginator
 */
class JobsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
	public $paginate = array(
            'order' => array( 'Job.nr' => 'desc'),
            'fields' => array('id', 'nr', 'stop_day', 'rodzaj_arkusza', 'arkusze_netto', 'status'),
            'contain' => array('User.name', 'Order.id', 'Order.isekspres')
        );
	
	public function beforeFilter() {
    	parent::beforeFilter();
    	//$this->actionAllowed();
    	$this->set('links', $this->links );
	}	
	
	


/**
 * index method
 *
 * @return void
 */
	public function index( $par = null ) {
		
		$this->Job->recursive = 0;
		$this->Paginator->settings = $this->paginate;
		
		if( !$this->akcjaOK(null, 'index', $par) ) {
			//jeżeli ta akcja nie jest dozwolona przekieruj na inną dozwoloną
			switch($this->Auth->user('JX')) {
				case IDX_ALL:
				case IDX_SAL:
					return $this->redirect( array('action' => 'index') );
					break;
				case IDX_NO_PRIV:
					return $this->redirect( array('action' => 'index', 'all-but-priv') );
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
				$opcje = array();
			break;
			case 'all-but-priv':
				$opcje = array('OR' => array(
    					'Job.user_id' => $this->Auth->user('id'),
    					'Job.status !=' => sPRIVJ
					));
			break;
			case 'my':
				$opcje = array('Job.user_id' => $this->Auth->user('id'));
			break;
			case 'active':
				$opcje = array('OR' => array(
    				array('Job.user_id' => $this->Auth->user('id'), 'Job.status !=' => KONEC),
    				'Job.status !=' => array(sPRIVJ, KONEC)
				));
			break;
			case 'closed':
				$opcje = array('Job.status' => KONEC);
			break;	
                        case 'started':
				$opcje = array('Job.status !=' => array(sJ_PROD, KONEC));
			break;
			default:
				$opcje = array();
		}
                $this->Job->bindModel(
                    array('hasAndBelongsToMany' => array(
                            'Order' => array( 'joinTable' => 'cards')
                )));
                
                $this->Job->Behaviors->attach('Containable');
		if( !empty($opcje) ) {
                    $joby = $this->Paginator->paginate( 'Job', $opcje );	}		
		else { 
                    $joby = $this->Paginator->paginate(); }
                
                $jobs = $this->transform($joby);
		$this->set(compact('jobs', 'par'));
	}
        
        /* Chcemy dla kazdego Job'a, aby przeszukał korespondujące Handlowe, czy któreś nie jest EXPRESS
            Jeżeli tak, to żeby wpisał to do tablicy, Job'a - tak, by było widomo, że ekspres */
        private function transform( $produkcyjne ) {
            
            $i=0;
            foreach( $produkcyjne as $record ) {
                $produkcyjne[$i]['Job']['isekspres'] = false; $j=0;
                foreach( $record['Order'] as $order ) {
                    if( $order['isekspres'] ) {
                        $produkcyjne[$i]['Job']['isekspres'] = true;
                        break;
                    }
                }
                unset($produkcyjne[$i]['Order']);
                $i++;
            }
            return $produkcyjne;
        }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null, $print = null) {
		if (!$this->Job->exists($id)) {
			throw new NotFoundException(__('Invalid job'));
		}
		$options = array('conditions' => array('Job.' . $this->Job->primaryKey => $id));
		
		$job = $this->Job->find('first', $options);
		$users = $this->Job->User->find('all', array(
					'fields' => array( 'id','name','k'),
					'recursive' => 0
		));
		foreach( $users as $value) 
			$ludz[$value['User']['id']] = array(
				'name' => $value['User']['name'],
				'k' => $value['User']['k']
			);
			
		foreach( $job['Card'] as &$card) {
			if( $card['order_id'] ) {
				$order = $this->Job->Card->Order->find('first', array(
					'conditions' => array('Order.id' => $card['order_id']),
					'recursive' => 0
					//'fields' => array('id', 'numer')
				));
				$ordery[$card['id']] = $order;
			}
		}
		
		$submits = $this->prepareSubmits($job);
		$npug = $this->Auth->user('NPUG');
		$coptions= $this->Job->Card->view_options;
                
                $this->pdfConfig = array(
                    'margin' => array(
                        'bottom' => 25,
                        'left' => 7,
                        'right' => 7,
                        'top' => 7
                    ),
                    'orientation' => 'landscape', 
                                    //'portrait',
                    'filename' =>  $this->bnr2nrj2($job['Job']['nr'], null ,false, '-')
                 );
                // se testowalem
                //$href = str_replace("apacz","localhost", FULL_BASE_URL).$this->webroot.'css/order-pdf.css';
		$this->set( compact('job', 'ordery', 'submits', 'ludz', 'npug', 'coptions' ) );
		if( $print == 'print' ) {
			$this->layout = 'print';
			$this->render('druknij');
		}
	}


	private function prepareSubmits($job) {
		
		$tworca = $job['Job']['user_id'];
		$logged_dzial = $this->Auth->user('dzial');
		$status = $job['Job']['status'];
		$logged_user = $this->Auth->user('id');
		$submits = array();
                // jeżeli to kier. prod lub jego zastępca, to prawda
                $kiper = $logged_dzial == KIP || $this->Auth->user('kiper');
		
		if( count($job['Card']) ) { //zlecenie musi miec jakies karty
			
                    switch( $status ) {
                        case sPRIVJ:
                                if( $logged_dzial == SUA || $logged_user == $tworca ) {
                                    $submits[eJPUBLI] = 0; }//0 oznacza, że komentarz nie wymagany
                                break;
                        case sDTP_REQ:
                                if( $logged_dzial == DTP || $logged_dzial == SUA) {
                                        $submits[eJ_FILE1] = 0;						
                                }
                                break;
                        case sHAS_F1:
                        case sHAS_F2:
                                if( $logged_user == $tworca ) {
                                    $submits[eJF_OK] = 0;
                                    $submits[eJF_BACK] = 1;
                                }					
                        break;	
                        case sDTP2FIX:
                                if( $logged_dzial == DTP ) {
                                        $submits[eJ_FILE2] = 0;						
                                }
                        break;	
                        case sW4B:
                        case sW4B2: //#tu
                                if( $kiper ) {
                                    $submits[eJ_ACC] = 0;
                                    //$submits[eB_REJ] = 1;						
                                    $submits[eJ_B2KOR] = 1;
                                    $submits[eJ_B2DTP] = 1;
                                }
                        break;	
                        case sDTP2FIX2:
                                if( $logged_dzial == DTP ) {
                                        $submits[eJ_FILE3] = 0;						
                                }
                        break;
                        case sKOR2FIX:
                                if( $logged_user == $tworca ) {
                                        $submits[eJ_KOR2DTP] = 1;
                                        $submits[eJ_KOR2B] = 0;
                                }
                        break;
                        case sJ_PROD: //#tu
                                if( $kiper ) {
                                    $submits[eJ_COF2KOR] = 1;
                                    $submits[eJ_COF2DTP] = 1;
                                }
                        break;
                        case sPAUSE4K:
                                if( $logged_user == $tworca ) {
                                        $submits[eJ_KBACK] = 0;	
                                        $submits[eJ_KOR2DTP] = 1;
                                }
                        break;
                        case sPAUSE4D:
                                if( $logged_dzial == DTP ) {
                                        $submits[eJ_DBACK] = 0;						
                                }
                        break;
                        case sBACK2B: //#tu
                                if( $kiper ) {
                                    $submits[eJ_COF2KOR] = 1;
                                    $submits[eJ_COF2DTP] = 1;
                                    $submits[eJB_UNPAUSE] = 0;
                                }
                        break;





                        case sDAFC:
                                if( $logged_user == $tworca )
                                        $submits[eKOR_POP] = 0;
                                break;


                        case sASKOR:
                                if( $logged_user == $tworca ) {
                                        $submits[eK_POP4B] = 0;
                                        $submits[eK_PUSHDTP] = 0;
                                }
                        break;

                        case sB_REJ:
                                if( $logged_user == $tworca ) {
                                        $submits[eKOR_POP] = 0;
                                }
                                if( $logged_dzial == DTP ) {
                                        $submits[eJ_FILE] = 0;
                                }
                        break;
                    }
                    if( $status != sPRIVJ ) {
                        $submits[eJKOM] = 1; } // Nie można skomentować bez komentarza :-)
			
		}
		return $submits;
		
	}


/**
 * add method
 *
 * @return void
 */
    public function add() {
        if ($this->request->is('post')) {

            //$this->Job->print_r2($this->request->data);
            $res = $this->Job->prepareData($this->request->data);
            // $this->Job->print_r2($res);  return;
                        
            //$this->Job->create();
            if( !empty($res['Card']) ) {
                if ($this->Job->saveAssociated($res)) {
                    $this->Session->setFlash('Zlecenie zostało zapisane.');
                    return $this->redirect(array('action' => 'view', $this->Job->id)); }
                else {
                    $this->Session->setFlash( 'Zlecenie nie może być zapisane. Proszę, spróbuj ponownie.'); }			
            } else {
                   $this->Session->setFlash('MUSISZ WYBRAĆ JAKĄŚ KARTĘ!');
            }
        }

        if( !$this->akcjaOK(null, 'add') ) {
                $this->Session->setFlash('WYGLĄDA NA TO, ŻE NIE MASZ UPRAWNIEŃ...');
                return $this->redirect($this->referer());
        }


        $cards = $this->Job->findCards();
        //$kartki = $this->wyciag_karty($orders);
        $vju = $this->Job->get_view_options();
        $this->set( compact(/*'users', 'orders', 'kartki',*/ 'vju', 'cards') );
    }
	

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Job->exists($id)) {
			throw new NotFoundException(__('Invalid job'));
		}
		if ($this->request->is(array('post', 'put'))) {
			
			$res = $this->Job->prepareData($this->request->data);
			/*
			$this->Job->print_r2($this->request->data);			
			$this->Job->print_r2($res);
			return;
			
			*/
			if ( $this->Job->saveEdit($res) ) {
				$this->Session->setFlash($this->Job->jedMsg);
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('ZLECENIE NIE MOŻE BYĆ ZAPISANE, SPRÓBUJ PONOWNIE. ('.$this->Job->jedErr.')'));
			}
		} else {
			$options = array('conditions' => array('Job.' . $this->Job->primaryKey => $id));
			$this->request->data = $this->Job->find('first', $options);
			unset($this->request->data['Card']);
		}
		if( !$this->akcjaOK($this->request->data['Job'], 'edit') ) {
			$this->Session->setFlash('EDYCJA NIE JEST MOŻLIWA LUB NIE MASZ UPRAWNIEŃ...');
			return $this->redirect($this->referer());
		}
		$users = $this->Job->User->find('list');
		$cards = $this->Job->findCards($this->request->data);
		$vju = $this->Job->get_view_options();
		$this->set(compact('users', 'vju', 'cards'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Invalid job'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Job->delete()) {
			$this->Session->setFlash(__('The job has been deleted.'));
		} else {
			$this->Session->setFlash(__('The job could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	
	// sprawdzamy uprawnienia dla akcji w tym kontrolerze
	private function akcjaOK( $dane = array(), $akcja = null, $par = null ) {
	
		switch($akcja) {
			case 'add':
				if ( $this->Auth->user('JA') == HAS_RIGHT ) 
				return true;
			break;
			case 'edit':
				$job = $dane;
				if( 1 ) { //nie ma, poza uprawnieniami, innych przeszkód
					switch( $this->Auth->user('JE') ) {
						case EDIT_OWN:
							if( $this->Auth->user('id') == $job['user_id'] )
								return true;
						break;
						case EDIT_ALL:
						case EDIT_SAL:
							return true;
					}
				}
			break;
			case 'index':
                            $upraw = $this->Auth->user('JX');
                            switch($par) {
                                case null:
                                     if( $upraw == IDX_ALL || $upraw == IDX_SAL ) { return true;}
                                break;
                                case  'all-but-priv':
                                case  'active':
                                case  'closed':
                                        if( $upraw == IDX_NO_PRIV || $upraw == IDX_ALL || $upraw == IDX_SAL) { return true; }
                                break;
                                case 'started':
                                    return true;
                            }
			break;
		}
		return false;
	}

}
