<?php
App::uses('AppController', 'Controller');
/**
 * Uploads Controller
 *
 * @property Upload $Upload
 * @property PaginatorComponent $Paginator
 */
class UploadsController extends AppController {

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
		$this->Upload->recursive = 0;
		$this->set('uploads', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Upload->exists($id)) {
			throw new NotFoundException(__('Invalid upload'));
		}
		$options = array('conditions' => array('Upload.' . $this->Upload->primaryKey => $id));
		$this->set('upload', $this->Upload->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			//$this->Upload->print_r2($this->request->data);
			//$this->krd();
			//$this->Upload->print_r2($this->request->data);
			//return;
			// krd - konvertujemy wejściowe dane do poprawnej postci
			// i przesyłamy oraz zmieniamy nazwy plików wejściowych
			$this->Upload->create();
			if ( $this->krd() && $this->Upload->saveMany( $this->request->data ) ) {
				$this->Session->setFlash(__('The upload has been saved.'));
				return $this->redirect(array('action' => 'index'));
				
			} else {
				$this->Session->setFlash(__('The upload could not be saved. Please, try again. UPL-ERR='));
				$this->Session->setFlash( $gib );
			}
		}
		$vju = $this->Upload->view_options;
		$projects = $this->Upload->Project->find('list');
		$this->set(compact('projects','vju'));
	}
	
	public function krd() { // konvertuj $this->request->data
		
		$i=0;
		$result = array();
		$tabwe = $this->request->data;
		
		foreach ( $tabwe['Upload']['files'] as $value ) {
			
			if( $value['error'] === UPLOAD_ERR_OK ) {
				
				$id = String::uuid();
				if (move_uploaded_file($value['tmp_name'], APP.$this->Upload->uplpath.DS.$id)) {
					$row = array();
					$row['role'] = $tabwe['Upload'][$i++]['role'];
					$row['roletxt']= $this->Upload->view_options['role']['options'][strval($row['role'])];
      				$row['filename'] = $value['name'];
      				$row['filesize'] = $value['size'];
      				$row['filemime'] = $value['type'];
					$row['uuidname'] = $id;
					array_push($result, $row);
					
				}
				else return FALSE;
			}
			else return FALSE;
		}
		$this->request->data = $result;
  		return TRUE;
	}
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Upload->exists($id)) {
			throw new NotFoundException(__('Invalid upload'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Upload->save($this->request->data)) {
				$this->Session->setFlash(__('The upload has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The upload could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Upload.' . $this->Upload->primaryKey => $id));
			$this->request->data = $this->Upload->find('first', $options);
		}
		$projects = $this->Upload->Project->find('list');
		$this->set(compact('projects'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
 
	public function delete($id = null) {
		$this->Upload->id = $id;
		if (!$this->Upload->exists()) {
			throw new NotFoundException(__('Invalid upload'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Upload->delete()) {
			$this->Session->setFlash(__('The upload has been deleted.'));
		} else {
			$this->Session->setFlash(__('The upload could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function download( $id ) {
		
		if ( !$id ) {
			throw new NotFoundException(__('Brak id pliku!'));
		}
		
		$options = array('conditions' => array('Upload.' . $this->Upload->primaryKey => $id));
		$data = $this->Upload->find('first', $options);
		
		$extension = substr($data['Upload']['filename'], strripos($data['Upload']['filename'], '.') + 1 );
		
		$this->response->type( array( $extension => $data['Upload']['filemime'] ) );
		$this->response->type($extension);
                if( $data['Upload']['uuidname'] != NULL ) {
                    $uname = $data['Upload']['uuidname']; // po staremu
                } else {
                    $uname = $data['Upload']['new-uuidname']; // po nowemu
                }
		$this->response->file(
                    APP.$this->Upload->uplpath.DS.$uname, // path
                    array( 'download' => true, 'name' => $data['Upload']['filename'] )
		);
		return $this->response;
		
	}
	
	

}
