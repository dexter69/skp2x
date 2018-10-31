<?php
App::uses('AppController', 'Controller');
/*
*   1.10.2018
*   Kontroler dedykowany do zamówień dla Webix
*/

class WebixOrdersController extends AppController {

    public function beforeFilter() { $this->Auth->allow(
        
        'quickOrderSave'
    ); 
    }

    /**
     * Zwróć dane zamówienia z powiązanymi kartami. Wersja light, czyli nie dużo danych. */    
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

    // Zapisz w bazie zamówienie dodane w trybie quick
    public function quickOrderSave() {

        $back = $this->request->data;
        $back["result"] = [
            'success' => true,
            'msg' => 'Gites majonez!'
        ];
        $this->set(compact(['back']));
        $this->set('_serialize', 'back');
    }
}
