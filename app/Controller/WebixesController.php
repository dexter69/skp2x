<?php

/*
*   26.09.2018
*   Kontroler, na którym oprzemy Webix'ową część SKP
*/

App::uses('AppController', 'Controller');

class WebixesController extends AppController {

    // Js files składajace się na aplikację

    private $webixJsFiles = [
        "/webix/app/js/content/orders/privateOrders/conf.js",
        "/webix/app/js/content/orders/privateOrders/eventsHandlers.js",
        "/webix/app/js/content/orders/privateOrders/listOfPrivateOrders.js",
        "/webix/app/js/content/orders/theOrderDetail/listOfCards.js",
        "/webix/app/js/content/orders/theOrderDetail/theOrderDetail.js",
        "/webix/app/js/content/orders/managePrivateOrders.js",
        "/webix/app/js/content/orders/manageAddingQuickOrder.js",    
        "/webix/app/js/content/customers/listOfCustomers.js",    
        "/webix/app/js/layout/mainToolbar.js",
        "/webix/app/js/layout/leftSidebar.js",                
        "/webix/app/js/layout/content.js"
    ];

    public function index() {
        
        // Informacje o zalogowanym uzytkowniku - tylko to, co potrzebujemy
        $loggedInUser = [
            'id' => $this->Auth->user('id'),
            'name' => $this->Auth->user('name'),
            'inic' => $this->Auth->user('inic')
        ];        
        
        $this->layout='webix';
        $webixJsFiles = $this->webixJsFiles;
        $this->set(compact( ['loggedInUser', 'webixJsFiles'] ));
        //$this->render(false); // na razie nie potrzebujemy view w .ctp
    }  

}  