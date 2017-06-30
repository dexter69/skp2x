<?php

App::uses('AppController', 'Controller');

class RequestsController extends AppController {

    public $helpers = array('Ma');

    public function index() {

        // Date picker config
        $config = $this->dataForTheDatePicker();
        $jscode =   "var test = " . json_encode($config);
        
        $this->set( compact('jscode', 'config') );        
        $this->layout='bootstrap';
	}

    private function dataForTheDatePicker() {

        return [
            'label' => 'Od:',
            'years' => [2017, 2016, 2015, 2014],
            'anydate' => true
            //'anydate' => false
        ];        
    }

}