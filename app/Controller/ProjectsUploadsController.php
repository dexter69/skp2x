<?php
App::uses('AppController', 'Controller');
/**
 * ProjectsUploads Controller
 *
 * @property ProjectsUpload $ProjectsUpload
 * @property PaginatorComponent $Paginator
 */
class ProjectsUploadsController extends AppController {

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
		$this->ProjectsUpload->recursive = 0;
		$this->set('projectsUploads', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ProjectsUpload->exists($id)) {
			throw new NotFoundException(__('Invalid projects upload'));
		}
		$options = array('conditions' => array('ProjectsUpload.' . $this->ProjectsUpload->primaryKey => $id));
		$this->set('projectsUpload', $this->ProjectsUpload->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ProjectsUpload->create();
			if ($this->ProjectsUpload->save($this->request->data)) {
				$this->Session->setFlash(__('The projects upload has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The projects upload could not be saved. Please, try again.'));
			}
		}
		$projects = $this->ProjectsUpload->Project->find('list');
		$uploads = $this->ProjectsUpload->Upload->find('list');
		$this->set(compact('projects', 'uploads'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ProjectsUpload->exists($id)) {
			throw new NotFoundException(__('Invalid projects upload'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProjectsUpload->save($this->request->data)) {
				$this->Session->setFlash(__('The projects upload has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The projects upload could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ProjectsUpload.' . $this->ProjectsUpload->primaryKey => $id));
			$this->request->data = $this->ProjectsUpload->find('first', $options);
		}
		$projects = $this->ProjectsUpload->Project->find('list');
		$uploads = $this->ProjectsUpload->Upload->find('list');
		$this->set(compact('projects', 'uploads'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ProjectsUpload->id = $id;
		if (!$this->ProjectsUpload->exists()) {
			throw new NotFoundException(__('Invalid projects upload'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ProjectsUpload->delete()) {
			$this->Session->setFlash(__('The projects upload has been deleted.'));
		} else {
			$this->Session->setFlash(__('The projects upload could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
