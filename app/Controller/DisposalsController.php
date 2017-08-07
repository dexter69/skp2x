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
        $disposals = $this->Paginator->paginate( 'Disposal');        
        
        $data = $this->Disposal->otrzymane; 
        $this->set( compact( ['data', 'disposals']) ); 
        
    }

    public function searchx() {

        // Zapisujemy w modelu otrzymane
        $this->Disposal->otrzymane = $this->request->data;
        $x = $this->Disposal->searchParams;
        $data = $this->Disposal->theSearch();        
        $this->Paginator->settings = $y = $this->paginate = $this->Disposal->searchParams;        
        $disposals = null;
        $disposals = $this->Paginator->paginate( 'Disposal');
        array_unshift($data, $this->request->data);
        $this->layout='ajax';
        $this->set( compact( ['data', 'x', 'y', 'disposals']) ); 
    }

}