<?php
App::uses('AppController', 'Controller');

class ServisCardsController extends AppController {

    public function index() {
         
        $servisCards = $this->ServisCard->find('all')  ;
        $this->set(compact(['servisCards']));
        $this->set('_serialize', 'servisCards');
    }

}