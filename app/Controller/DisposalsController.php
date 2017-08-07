<?php

App::uses('AppController', 'Controller');

class DisposalsController extends AppController {

    public $helpers = array('Ma', 'BootForm', 'Boot');
    
    public function index() {

        // Date picker config
        $config = $this->Disposal->configForSpecialSearching;  
        
        $this->set( compact('config') );        
        $this->layout='bootstrap';
	}   

    public function search() {

        // Zapisujemy w modelu otrzymane
        $this->Disposal->otrzymane = $this->request->data;
        
        $data = $this->Disposal->theSearch();        
        array_unshift($data, $this->request->data);
        $this->layout='ajax';
        $this->set( compact( 'data') ); 
    }

}