<?php
App::uses('AppController', 'Controller');
/*
*   1.10.2018
*   Kontroler dedykowany do zamówień dla Webix
*/

class WebixOrdersController extends AppController {

    /**
     * Zwróć dane zamówienia z powiązanymi kartami. Wersja light, czyli nie dużo danych.
     */    
    public function getOneOrderLight( $id = 0 ) { 

        if( 0 ) { // Jezeli takie zamówienie nie istnieje

            return 0;
        }        
        $theOrder = $this->WebixOrder->getTheOrderLight($id);        
        $theOrder['WebixOrder']['ileKart'] = count($theOrder['WebixCard']);
        $theOrder = $this->WebixOrder->mergeCakeData($theOrder);        
        $this->set(compact(['theOrder']));
        $this->set('_serialize', 'theOrder');
    }
}
