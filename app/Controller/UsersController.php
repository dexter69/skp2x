<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        
        public function hash( $ile = 1 ) {
            
            $time_start = microtime(true);
            $wynik = array(); $jest = 0; $mzi = 0;          
            for ($x = 0; $x < $ile; $x++) {
                $hashVal = $this->User->hashMe(String::uuid());
                $arr2 = $this->podziel($hashVal);
                $v1 = $arr2[0];
                $v2 = $arr2[1];
                $mzi += $this->mzi($v1);
                $mzi += $this->mzi($v2); //in_array("mac", $os)
                if( ! in_array($v1, $wynik, true) ) { $wynik[] = $v1; } else { $jest++; }
                if( ! in_array($v2, $wynik, true) ) { $wynik[] = $v2; } else { $jest++; }                
//                if( $this->nieMaWtab($v1, $wynik) ) { $wynik[] = $v1; } else { $jest++; }
//                if( $this->nieMaWtab($v2, $wynik) ) { $wynik[] = $v2; } else { $jest++; }                
            } 
            $czas = microtime(true) - $time_start;
            $this->set(compact('wynik', 'jest', 'mzi', 'czas'));
        }
        
        private function mzi($str) {
            
            $char = substr($str, 0, 1);
            if(
                $char == 'M' ||
                $char == 'Z' ||
                $char == 'I' ||                        
                $char == 'm' ||
                $char == 'z' ||
                $char == 'i' 
            ) { return 1; }
            return 0;
        }
        private function podziel($str = null) {
            
            $arr = array( '', '');
            if( strlen($str) == 40 ) {
                $strarr = str_split($str);
                for ($x = 0; $x < 40; $x=$x+2) {
                    $arr[0] .= $strarr[$x];
                    $arr[1] .= $strarr[$x+1];
                }
            }
            return $arr;
        }
        
        private function nieMaWtab($war, $tab) {
            
            foreach($tab as $val) {
                if( $war === $val) {
                    return false;
                }
            }
            return true;
        }
        
        private $nie_ten_dzial = true;
        
	public function beforeFilter() {
            parent::beforeFilter();
            // Poniższe potrzebne, by móc dodać użytkownika bez loggowania (gdy nie ma jeszcze żadnego)            
            //$this->Auth->allow('add', 'logout'); // Allow users to register and logout.
            
            // a teraz chcemy, aby nikt poza SUA nie mógł wykonywać pewnych akcji
            $this->nie_ten_dzial = ( $this->Auth->user('dzial') != SUA );
            $nie_ta_akcja = in_array($this->request->params['action'], array('view', 'edit', 'delete'));
            if( $this->nie_ten_dzial && $nie_ta_akcja ) {
                $this->Session->setFlash( 'Nie da rady...');
                return $this->redirect(array('action' => 'index'));
            } 
	}

	public function login() {

        $ajax = $this->myAjax;
        $this->set(compact(array('ajax')));
        if ($this->request->is('post') && !$this->request->is('ajax')) {
            if ($this->Auth->login()) {
                switch( $this->Auth->user('dzial') ) {
                    case KON: // kontrola jakości
                        $red = array('controller'=>'tasks', 'action' => 'label');
                        break;
                    case PRO: // produkcja 
                        $red = array('controller'=>'jobs', 'action' => 'index');
                        break;
                    default:
                        $red = $this->Auth->redirect();
                }
                return $this->redirect($red);                                       
            }
            $this->Session->setFlash(__('Błędna nazwa użytkownika lub hasło, spróbuj ponownie'));
        }
	}

	public function logout() {
    	return $this->redirect($this->Auth->logout());
	}
	
	// zdecyduj, gdzie użytkownik ma być przekierowany po zalogowaniu
	public function przekieruj() { 
		return $this->redirect( array('controller' => 'orders', 'action' => 'index', 'active'));
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
                //$arr = $this->request->params;
                //$arr['ekstra'] = $this->testek;
                
                $users = $this->Paginator->paginate();                
		//$this->set('users', $this->Paginator->paginate());
                $short = $this->nie_ten_dzial;
                $this->set(compact(array('users', 'short')));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$vju = $this->User->view_options; // opcje wyświetlania pól zdef. w modelu
		$this->set(compact('vju'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
