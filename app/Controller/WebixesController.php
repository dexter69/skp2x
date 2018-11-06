<?php

/*
*   26.09.2018
*   Kontroler, na którym oprzemy Webix'ową część SKP
*/

App::uses('AppController', 'Controller');

class WebixesController extends AppController {

    // Js files składajace się na aplikację

    private $webixJsFiles = [
        "/webix/app/js/content/customers/listOfCustomers",
        "/webix/app/js/content/orders/addNewQuickOrder",
        "/webix/app/js/content/orders/privateOrders/conf",
        "/webix/app/js/content/orders/privateOrders/eventsHandlers",
        "/webix/app/js/content/orders/theOrderDetail/listOfCards",
        "/webix/app/js/content/orders/theOrderDetail/theOrderDetail",
        "/webix/app/js/content/orders/privateOrders/listOfPrivateOrders",
        "/webix/app/js/content/orders/managePrivateOrders",
        "/webix/app/js/content/orders/manageAddingQuickOrder",          
        "/webix/app/js/layout/mainToolbar",
        "/webix/app/js/layout/leftSidebar",                
        "/webix/app/js/layout/content"
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