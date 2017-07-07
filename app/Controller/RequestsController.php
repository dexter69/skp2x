<?php

App::uses('AppController', 'Controller');

class RequestsController extends AppController {

    public $helpers = array('Ma', 'BootForm');

    public function index() {

        // Date picker config
        $config = $this->itWillBeTheRequestObj();        
        
        $this->set( compact('config') );        
        $this->layout='bootstrap';
	}

    private function itWillBeTheRequestObj() {

        $theObjName = 'request';
        return [
            'objname' => $theObjName, // nazwa obiektu, który będzie przechowywał dane
            // struktura dla daty od
            'od' => [
                'id' => 'picker-od',
                'label' => 'Od:',
                'value' => null, // wartość daty początkowa
                'acc' => $theObjName . '.od.value' /* Tekstowa wartość ibiektu albo klucza,
                do którego skrypt ma zapisywać vartośc wybranej daty */                
            ],
            // struktura dla daty do
            'do' => [
                'id' => 'picker-do',
                'label' => 'Do:',
                'value' => null, // wartość daty początkowa
                'acc' => $theObjName . '.do.value'                
            ]
        ];
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