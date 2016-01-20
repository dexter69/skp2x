<?php
App::uses('AppController', 'Controller');
/**
 * Proofs Controller
 *
 * @property Proof $Proof
 * @property PaginatorComponent $Paginator
 */
class ProofsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


/* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
         Te poniżej BAKED 
 */

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Proof->recursive = 0;
		$this->set('proofs', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Proof->exists($id)) {
			throw new NotFoundException(__('Invalid proof'));
		}
		$options = array('conditions' => array('Proof.' . $this->Proof->primaryKey => $id));
		$this->set('proof', $this->Proof->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Proof->create();
			if ($this->Proof->save($this->request->data)) {
				$this->Session->setFlash(__('The proof has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The proof could not be saved. Please, try again.'));
			}
		}
		$cards = $this->Proof->Card->find('list');
		$this->set(compact('cards'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Proof->exists($id)) {
			throw new NotFoundException(__('Invalid proof'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Proof->save($this->request->data)) {
				$this->Session->setFlash(__('The proof has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The proof could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Proof.' . $this->Proof->primaryKey => $id));
			$this->request->data = $this->Proof->find('first', $options);
		}
		$cards = $this->Proof->Card->find('list');
		$this->set(compact('cards'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Proof->id = $id;
		if (!$this->Proof->exists()) {
			throw new NotFoundException(__('Invalid proof'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Proof->delete()) {
			$this->Session->setFlash(__('The proof has been deleted.'));
		} else {
			$this->Session->setFlash(__('The proof could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
