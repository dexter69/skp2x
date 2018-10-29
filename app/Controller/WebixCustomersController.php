<?php
App::uses('AppController', 'Controller');

class WebixCustomersController extends AppController {

    public function beforeFilter() {
        $this->Auth->allow('getForAddingAnOrder');
    }

    public function getForAddingAnOrder() {

        if ($this->request->is('post')) {  // normalnie będziemy wysyłać ajax post
            $fraza = $this->request->data["fraza"];
            $realOwnerId = $this->request->data["realOwnerId"];
        } else { // dla testów z przeglądrką
            $fraza = "ara";
            $realOwnerId = 0; // wszyscy handlowcy
        }
        $limit = 50; // Limit znajdowanych rekordów
        $theCustomers = $this->WebixCustomer->getCustomersForAddingAnOrder(
            $fraza, // szukane znaki w nazwie customer'a
            $realOwnerId, // id stałego opiekuna klienta 
            $limit // max ilość rekordów
        );         
        $theCustomers['req'] = $this->request->data;        
        $this->set(compact(['theCustomers']));
        $this->set('_serialize', 'theCustomers');    
    }

}