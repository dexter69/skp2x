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
        "/webix/app/js/content/customers/customerDetail",
        "/webix/app/js/content/customers/customerPanel",
        "/webix/app/js/content/orders/privateOrders/conf",
        "/webix/app/js/content/orders/privateOrders/eventsHandlers",
        "/webix/app/js/content/orders/theOrderDetail/listOfCards",
        "/webix/app/js/content/orders/theOrderDetail/theOrderDetail",
        "/webix/app/js/content/orders/privateOrders/listOfPrivateOrders",
        "/webix/app/js/content/orders/managePrivateOrders",                  
        "/webix/app/js/content/customers/manageCustomers", 
        "/webix/app/js/layout/toolbarMenu",
        "/webix/app/js/layout/mainToolbar",
        "/webix/app/js/layout/leftSidebar",                
        "/webix/app/js/layout/content",
        "/webix/app/js/app" // nasz entry point
    ];

    //private $webixJsFiles = [ "/webix/app/js/app-dist" ];

    public function index() {
        
        // Informacje o zalogowanym uzytkowniku - tylko to, co potrzebujemy
        $loggedInUser = [
            'id' => $this->Auth->user('id'),
            'name' => $this->Auth->user('name'),
            'inic' => $this->Auth->user('inic')
        ];    
        
        // Limitujemy możliwość wyświetlenia listy klientów
        if( !$this->dozwolonaAkcja() ) {
            $this->Session->setFlash('NIE MOŻNA WYŚWIETLIĆ LUB NIE MASZ UPRAWNIEŃ.');
            return $this->redirect($this->referer());
        }

        if ( $this->Auth->user('CX') == IDX_OWN) {
            // Jeżeli użytkownik ma uprawnienia do listowania tylko swoich klientów
            // To przekierowujemy na starą listę (bo w Webixach za dużo przerabiania)
            return $this->redirect( array('controller' => 'customers', 'action' => 'index', 'my') );
            
        }
        
        $this->layout='webix';
        $webixJsFiles = $this->webixJsFiles;        
        $handlowcy = $this->Webix->listaHandlowcowDoPulpitu();
        $this->set(compact( ['loggedInUser', 'webixJsFiles', 'handlowcy'] ));
        //$this->render(false); // na razie nie potrzebujemy view w .ctp
    }  

}  