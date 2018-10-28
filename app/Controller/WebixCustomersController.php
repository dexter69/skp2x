<?php
App::uses('AppController', 'Controller');

class WebixCustomersController extends AppController {

    public function beforeFilter() {
        $this->Auth->allow('getForAddingAnOrder');
    }

    public function getForAddingAnOrder() {

        $limit = 3;        
        $theCustomers = $this->WebixCustomer->getCustomersForAddingAnOrder(
            $this->request->data["fraza"], // szukane znaki w nazwie customer'a
            $this->request->data["realOwnerId"], // id stałego opiekuna klienta 
            $limit // max ilość rekordów
        );         
        $theCustomers['req'] = $this->request->data;        
        $this->set(compact(['theCustomers']));
        $this->set('_serialize', 'theCustomers');    
    }

}