<?php

/*
*  Kontroler do zamówień z WEBIX
*/

App::uses('AppController', 'Controller');

class RequestsController extends AppController {       
    
    /*
    Dodaj nowe zamówienie */
    public function dodaj() {

        $id = 0;
        $this->set( compact( 'id' ) ); 
        $this->set('title_for_layout', 'Nowe zamówienie');
        $this->layout='webix';
        $this->render('addedit');
    }

    /*
    Edytuj zamówienie */
    public function edytuj( $id = null ) {

        $this->set( compact( 'id' ) ); 
        $this->set('title_for_layout', 'Edycja zamówienia');
        $this->layout='webix';
        $this->render('addedit');
    }

}