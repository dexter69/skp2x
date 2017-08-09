<?php

App::uses('AppController', 'Controller');

class DisposalsController extends AppController {

    public $helpers = array('Ma', 'BootForm', 'Boot');

    public $components = array('Paginator');
    
    public $paginate = null;

    public function index() {

        // Date picker config
        $config = $this->Disposal->configForSpecialSearching;  
        
        $this->set( compact('config') );        
        $this->layout='bootstrap';
	}   

    public function search() {

        // Ustawiamy parametry szukania, na podstawie otrzymanych danych
        $this->paginate = $this->Disposal->setTheSearchParams($this->request->data);

        $this->Paginator->settings = $this->paginate;                
        $disposals = $this->Disposal->theSpecialFind();
        $howmuc = 0;//$this->Disposal->theSpecialFindIle(); // ile wszystkich rekordów
        
        $data = $this->Disposal->otrzymane; 
        $this->set( compact( ['data', 'disposals', 'howmuc']) ); 
        
    }

}