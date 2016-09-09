<?php
App::uses('AppController', 'Controller');
/**
 * Projects Controller
 *
 * @property Project $Project
 * @property PaginatorComponent $Paginator
 */
class ProjectsController extends AppController {

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
		$this->Project->recursive = 0;
		$this->set('projects', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__('Invalid project'));
		}
		$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
		$this->set('project', $this->Project->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			// chcemy mieć zalogowanego użytkownika
			$this->request->data['Card']['user_id'] = $this->Auth->user('id');
			//$this->Project->print_r2($this->request->data);
			//return;
			//$this->Project->create(); JEST WYWOŁYWANE W Funkcji saveitAll
			if ($this->Project->saveitAll($this->request->data, $blad)) {
				$this->Session->setFlash(__('The project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'));
			}
		}
		
		// opcje wyświetlania pól zdefiniowane w modelu
		$vju = $this->Project->get_view_options();
		$vju['file'] = $this->Project->Upload->view_options['file'];
		$vju['role'] = $this->Project->Upload->view_options['role'];
		//$this->Project->print_r2($vju);
		$uploads = $this->Project->Upload->find('list');
		//$customers = $this->Project->Card->Customer->find('list');
		
		$customers = $this->Project->Card->Customer->find('list',
			array('conditions' => array('user_id' => $this->Auth->user('id'))));
		/*
		znajdz karty, ktore nie są podpięte - mają order_id = 0
		i należą do zalogowanego użytkownika user_id
		
		wyciągnij listę plików podpiętych do tych kart i podziel na klientow
		
		*/
		$karty = $this->Project->Card->find('list',
			array('fields' => array('project_id'/*, 'name'*/),
				'conditions' => array(
										'user_id' => $this->Auth->user('id'),
										'order_id' => 0
										)
				));
				
		$pliki = $this->Project->find('all', array(
					'conditions' => array('id' => 12 )
		));				
		
		$this->set(compact('uploads','customers', 'vju', 'karty', 'pliki'));
	}



/**
 * add method, oryginalna prawie
 *
 * @return void
 */
	public function addprj() {
		if ($this->request->is('post')) {
			$this->Project->print_r2($this->request->data);
			return;
			$this->Project->create();
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'));
			}
		}
		
		// opcje wyświetlania pól zdefiniowane w modelu
		$vju = $this->Project->get_view_options();
		
		$uploads = $this->Project->Upload->find('list');
		$this->set(compact('uploads','vju'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__('Invalid project'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
			$this->request->data = $this->Project->find('first', $options);
		}
		$uploads = $this->Project->Upload->find('list');
		$this->set(compact('uploads'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			throw new NotFoundException(__('Invalid project'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Project->delete()) {
			$this->Session->setFlash(__('The project has been deleted.'));
		} else {
			$this->Session->setFlash(__('The project could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
