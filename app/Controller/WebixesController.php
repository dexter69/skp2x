<?php

/*
*   26.09.2018
*   Kontroler, na którym oprzemy Webix'ową część SKP
*/

App::uses('AppController', 'Controller');

class WebixesController extends AppController {

    public function index() {
        
        // Informacje o zalogowanym uzytkowniku - tylko to, co potrzebujemy
        $loggedInUser = [
            'id' => $this->Auth->user('id'),
            'name' => $this->Auth->user('name'),
            'inic' => $this->Auth->user('inic')
        ];        
        
        $this->layout='webix';
        $this->set(compact( ['loggedInUser'] ));
        //$this->render(false); // na razie nie potrzebujemy view w .ctp
    }  

}  