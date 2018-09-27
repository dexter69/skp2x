<?php

/*
*   26.09.2018
*   Kontroler, na którym oprzemy Webix'ową część SKP
*/

App::uses('AppController', 'Controller');

class WebixesController extends AppController {

    public function index() {
        
        $this->layout='webix';
        //$this->render(false); // na razie nie potrzebujemy view w .ctp
    }  

}  