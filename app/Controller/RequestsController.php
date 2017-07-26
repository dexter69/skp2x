<?php

App::uses('AppController', 'Controller');

class RequestsController extends AppController {

    public $helpers = array('Ma', 'BootForm', 'Boot');

    // Szukaj wg zadanych parametrów
    public function search() {

        $answer = 'Tu będzie w przyszłości odpowiedź';
        $data = $this->request->data;
        $this->set( compact('answer', 'data') ); 
        $this->layout='ajax'; // nie wysyłamy całej struktury strony tylko fragment html
        //sleep(1); // w celach testowych
    }

    public function index() {

        // Date picker config
        $config = $this->Request->configForSpecialSearching;  
        
        $this->set( compact('config') );        
        $this->layout='bootstrap';
	}

    private function dataForTheDatePicker() {

        return [
            'label' => 'Od:',
            'old' => [
                'label' => 'Od:',
                'years' => [2017, 2016, 2015, 2014],
                'anydate' => true
                //'anydate' => false
            ]
        ];        
    }

}