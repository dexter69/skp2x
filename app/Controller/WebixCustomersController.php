<?php
App::uses('AppController', 'Controller');

class WebixCustomersController extends AppController {


    public function getForAddingAnOrder( $realOwnerId = 0 ) {

        $theCustomers = $this->WebixCustomer->getCustomersForAddingAnOrder( $realOwnerId ); 
        $this->set(compact(['theCustomers']));
        $this->set('_serialize', 'theCustomers');    
    }

}