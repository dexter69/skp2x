<?php
App::uses('AppController', 'Controller');

class WebixCustomersController extends AppController {

    // testowe get koszaste zamówiia
    public function getKosz() {

        $theCustomers = $this->WebixCustomer->getKosz();
        $this->set(compact(['theCustomers']));
        $this->set('_serialize', 'theCustomers');
    }

    //public function beforeFilter() {  $this->Auth->allow('getMany', 'getOne');  }

    public function getMany() {

        if ($this->request->is('post')) {  // normalnie będziemy wysyłać ajax post
            $fraza = $this->request->data["fraza"];
            $realOwnerId = $this->request->data["realOwnerId"];
            $limit = $this->request->data["limit"];

            if( $this->request->data["kosz"] == "false" ) {
                $kosz = false;                
                $theCustomers = $this->WebixCustomer->getMany(
                    $fraza, // szukane znaki w nazwie customer'a
                    $realOwnerId, // id stałego opiekuna klienta 
                    $limit // max ilość rekordów                    
                );
            } else {
                $kosz = true;                
                $theCustomers = $this->WebixCustomer->getKosz($realOwnerId, $fraza);
            }             
            $theCustomers['check'] = 'gora, kosz = ' . $kosz;
        } else { // dla testów z przeglądrką                       
            $theCustomers = $this->WebixCustomer->getKosz(); // koszowe            
            $theCustomers['check'] = 'dol';
        }
                       
        $theCustomers['req'] = $this->request->data;  
        
        $this->set(compact(['theCustomers']));
        $this->set('_serialize', 'theCustomers');    
    }

    /**
     * Przygotuj link dla klienta o id = $customerId  */
    public function generujLink( $customerId = 0 ) {

        $freeChain = $this->WebixCustomer->WebixChain->reserveChain($customerId);
        $this->set(compact(['freeChain']));
        $this->set('_serialize', 'freeChain');                
    }

    /**
     * Info dotyczące jednego klienta
     * $id - id klienta w bazie */
    public function getOne( $id = 0 ) {

        $theCustomer = $this->WebixCustomer->getOne( $id );
        $this->set(compact(['theCustomer']));
        $this->set('_serialize', 'theCustomer');
    }

    /**
     * Usuwamy klienta + jego wszystkie prywatne zmówienia + karty + adres siedziby */

    public function delete( $id = null, $del = true ) {

        $this->WebixCustomer->id = $id;        
        $result = [
            'err' => false,
            'msg' => "NULL",
            'delCOA' => null, // rezultat z usunięcia Klienta + Zamówień + Adresu
            'delCards' => null // rezultat z usunięcia kart
        ];
		if (!$this->WebixCustomer->exists()) { // Czy na pewno jest taki klient?
            $result['err'] = true;
            $result['msg'] = "NIE istnieje klienta o id=$id !";			
        } else { // OK istnieje
            $theCustomer = $this->WebixCustomer->getOne( $id ); // potrzebne nam dane         
            if( $theCustomer['WebixCustomer_howManyNonPrivateOrders'] == 0) { // prawda => można usuwać                
                if($del) {
                // ########### DANGER!
                $result['delCOA'] = $this->WebixCustomer->delete($id);
                if( $result['delCOA'] ) { // po co usuwać karty, gdy nie udało się klienta usunąć
                    $result['delCards'] = $this->WebixCustomer->WebixPrivateOrder->WebixCard->deleteAll(['WebixCard.customer_id' => $id]);
                    if( $result['delCards'] ) {
                        $result['msg'] = "Klient o id=$id oraz powiązane dane USUNIĘTE!";
                    }
                }                
                // <<<<<<<<<<< END OF Danger
                } else { // symulacja
                    $result['msg'] = "Klient id=$id bylby usuniety...";
                    $result['delCOA'] = $result['delCards'] = true; }
            } else {
                $result['err'] = true;
                $result['msg'] = "Klienta NIE można usuwać, bo posiada aktywne i/lub zakończone zamówienia!";
            }
        }        
        $this->set(compact(['result']));
        $this->set('_serialize', 'result');
    }

}