<?php

App::uses('AppController', 'Controller');

class RequestsController extends AppController {

    public $helpers = array('Ma', 'BootForm', 'Boot');

    public function index() {

        // Date picker config
        $config = $this->itWillBeTheConfig();   
        
        $this->set( compact('config') );        
        $this->layout='bootstrap';
	}

    private function itWillBeTheConfig() {

        $newObjName = 'request';
        $magDefault = 'bez';
        return [
            // dane dla daty od
            'od' => [
                'id' => 'picker-od',
                'label' => 'Od:',               
                'acc' => $newObjName . '.od' /* Tekstowa wartość ibiektu albo klucza,
                do którego skrypt ma zapisywać vartośc wybranej daty */                
            ],
            // dane dla daty do
            'do' => [
                'id' => 'picker-do',
                'label' => 'Do:',                
                'acc' => $newObjName . '.do'                
            ],
            'mag' => [ // konfiguracja selecta pod pasek mag
                'id' => 'magsel', // id elementu html
                'acc' => $newObjName . '.mag',
                'options' => [ /*
                    lista, opcje, w postaci klucz => wartość
                    wartość zostaje wyświetlona, jako element tekstowy
                    klucz zostaje wpisany do atrybutu value elementu li
                    */
                    $magDefault => 'Bez paska magnetycznego',
                    'hico' => 'HiCo',
                    'loco' => 'LoCo',
                    'any' => 'Dowolny pasek'
                ],
                'default' => $magDefault
            ], 
            'varname' => $newObjName,
            /*  struktura tworzonego obiektu w którym będą przechowywane dane odnośnie
                parametrów poszukiwań */
            'theobj' => [ 
                'od' => null, // Data od
                'do' => null,  // data do
                'mag' => null // Rdzaj paska magnetycznego                    
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