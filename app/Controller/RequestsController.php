<?php

App::uses('AppController', 'Controller');

class RequestsController extends AppController {

    public $helpers = array('Ma', 'BootForm', 'Boot');
    
    public function index() {

        // Date picker config
        $config = $this->Request->configForSpecialSearching;  
        
        $this->set( compact('config') );        
        $this->layout='bootstrap';
	}    

}