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
        
        // Ludziska, którzy mają prywatne zamówienia
        $privHandlowcy = [
            ['id'=>0, 'value'=>"Wszyscy"],
            ['id'=>1, 'value'=>"Darek"],
            ['id'=>2, 'value'=>"Beata"],
            ['id'=>3, 'value'=>"Agnieszka"],
            ['id'=>10, 'value'=>"Renatax"],
            ['id'=>11, 'value'=>"Marzena"],
            ['id'=>31, 'value'=>"Piotr"]
        ];
        $this->layout='webix';
        $this->set(compact( ['loggedInUser', 'privHandlowcy'] ));
        //$this->render(false); // na razie nie potrzebujemy view w .ctp
    }  

}  