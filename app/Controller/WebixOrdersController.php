<?php
App::uses('AppController', 'Controller');
/*
*   1.10.2018
*   Kontroler dedykowany do zamówień dla Webix
*/

class WebixOrdersController extends AppController {

    /*
    Czyje prywatne chcemy?  */    

    public function getPrivateOrders() {
        // sprawdzamy, czy mamy od Webix'a to co potrzebujemy
        if( array_key_exists("filter" , $this->request->data) ) { // taki format daje nam Webixowy serverSelectFilter
            //$name = $this->extractTheName($this->request->data["filter"]);
            $idHandlowca = $this->extractTheId($this->request->data["filter"]);
            //$theOrders = $this->WebixOrder->getAllPrivateOrdersByUserName( $name );
            $theOrders = $this->WebixOrder->getAllPrivateOrders( $idHandlowca );
            //$theOrders = [];
        } else {
            // Nie - po prostu znajdź wszystkie prywatne dla wszystkich handlowców            
            //$theOrders = $this->WebixOrder->getAllPrivateOrders($this->request->data['opiekunId']);
            $theOrders = $this->WebixOrder->getAllPrivateOrders();
        }
        $theOrdersFormated/*['records']*/ = $this->formatForWebix($theOrders);   
        //$theOrdersFormated['rq'] = $this->request->data['opiekunId'];     

        $this->set(compact(['theOrders', 'theOrdersFormated']));
        $this->set('_serialize', 'theOrdersFormated');
    }

    private function extractTheId( $filterData = "" ) {

        $decoded = json_decode($filterData, true); // spodziewamy się json string
        return (int)$decoded["creatorName"]; // dlaczego "creatorName" ?
    }

    private function extractTheName( $filterData = "" ) {

        $decoded = json_decode($filterData, true); // spodziewamy się json string
        return $decoded["creatorName"]; // dlaczego "creatorName" ?
    }

    // Formatujemy dane dla Webix'a
    private function formatForWebix( $in = [] ) {

        $out = [];
        foreach( $in as $row ) {
            
            $outRow = $row['WebixOrder'];
            if( $outRow['nr'] ) { // Mimo, ze to prywatne, niektóre mają numery
                $outRow['nrTxt'] = $this->WebixOrder->bnr2nrh2($outRow['nr'], $row['WebixOrderCreator']['inic'], false);
            } else {
                $outRow['nrTxt'] = null;
            }
            $outRow['customerName'] = $row['WebixCustomer']['name'];
            $outRow['customerEmail'] = $row['WebixCustomer']['email'];
            $outRow['creatorName'] = $row['WebixOrderCreator']['name'];            
            $out[] = $outRow;
        }
        return $out;
    }

    public function testData() {

        $prywatneZamowienia = [
            [ //'id'=>1, 
            'opiekun'=>'Beta', 'id'=> 9946, 'customerName' => "Klient 1",  'termin'=> '29 XI 2018', 'status'=> 'PRYWATNE'],
            [ //'id'=>2, 
            'opiekun'=>'Renata', 'id'=> 2569, 'customerName' => "The Godfather jest słaby",             'termin'=> '19 XI 2018', 'status'=> 'PRYWATNE'],
            [ //'id'=>3, 
            'opiekun'=>'Agnieszka', 'id'=> 6974, 'customerName' => "Multiklient",    'termin'=> '15 XI 2018', 'status'=> 'PRYWATNE'],
            [ //'id'=>4, 
            'opiekun'=>'Marzena', 'id'=> 3994, 'customerName' => "Pulp friction klient",              'termin'=> '23 XI 2018', 'status'=> 'PRYWATNE']
        ];

        $this->set(compact('prywatneZamowienia'));
        $this->set('_serialize', 'prywatneZamowienia');
    }
}
