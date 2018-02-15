<?php

/*
*  Kontroler do zamówień z WEBIX
*/

App::uses('AppController', 'Controller');

class RequestsController extends AppController {
       
    public function test() {

        
        $this->layout='webix';
        //$this->set( compact( 'data') ); 
    }

}