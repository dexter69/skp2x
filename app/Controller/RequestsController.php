<?php

/*
*   Kontroler do zamówień z WEBIX
*   Update 26.09.2018: To zostawiamy jak jest - w celach testowych,
*   itp. a przenosimy pracę do WebixesController
*/

App::uses('AppController', 'Controller');

class RequestsController extends AppController {       
    
    /*
    Dodaj nowe zamówienie */
    public function dodaj() {

        $id = 0;
        $this->set( compact( 'id' ) ); 
        $this->set('title_for_layout', 'Dodaj ZAMÓWIENIE');
        $this->layout='webix.1';
        $this->render('addedit');
    }

    /*
    Edytuj zamówienie */
    public function edytuj( $id = null ) {

        $this->set( compact( 'id' ) ); 
        $this->set('title_for_layout', 'Edytuj ZAMÓWIENIE');
        $this->layout='webix.1';
        $this->render('addedit');
    }

}