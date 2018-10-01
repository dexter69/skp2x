<?php
App::uses('AppController', 'Controller');
/*
*   1.10.2018
*   Kontroler dedykowany do zamówień dla Webix
*/

class WebixOrdersController extends AppController {

    
    /*
    Czyje prywatne chcemy? Jezeli $idHandlowca == 0, to wszystkie */
    public function privateOrders( $idHandlowca = 0 ) { 

        //$this->request->onlyAllow('ajax');

        $theOrders = $this->WebixOrder->getAllPrivateOrders( $idHandlowca );
        //$theOrders[] = ['paramaetr' => $idHandlowca ];
        $this->set(compact('theOrders'));
        $this->set('_serialize', 'theOrders');
    }
}
