<?php
App::uses('AppController', 'Controller');
/*
*   1.10.2018
*   Kontroler dedykowany do zamówień dla Webix
*/

class WebixOrdersController extends AppController {

    /*
    testuje webix wrap dla privateOrders */
    public function privOrders() {

        $this->privateOrders();
    }
    
    /*
    Czyje prywatne chcemy? Jezeli $idHandlowca == 0, to wszystkie */
    public function privateOrders() {  

        //$this->request->onlyAllow('ajax');
        $idHandlowca = 0;
        $webixData = $this->request->data; // co nam webix przesłał

        // sprawdzamy, czy mamy od Webix'a to co potrzebujemy
        if( array_key_exists("filter" , $webixData) ) { // dlaczego "creatorName" ?
            // tak -> to szukamy w bazie po imieniu Handlowca - tak na ten moment działa filtr Webix
            //$theOrders = $this->WebixOrder->getAllPrivateOrders( $idHandlowca, $webixData["creatorName"] );
            $theOrders = $this->WebixOrder->getAllPrivateOrders( $idHandlowca );
            $theOrdersFormated = $this->formatForWebix($theOrders);
            $theOrdersFormated[] = $webixData; 
            $decoded = json_decode($webixData["filter"], true);
            $theOrdersFormated[] = [
                //'name' => $webixData["creatorName"]
                'xyz' => $decoded["creatorName"]
            ];
        } else {
            // Nie - po prostu znajdź wszystkie prywatne dla wszystkich handlowców
            $theOrders = $this->WebixOrder->getAllPrivateOrders( $idHandlowca );
            $theOrdersFormated = $this->formatForWebix($theOrders);
            $theOrdersFormated[] = $webixData; 
        }

        
        

        

        

        //$theOrdersFormated[] = ['kwa' => 'muu'];
        
        $this->set(compact(['theOrders', 'theOrdersFormated']));
        $this->set('_serialize', 'theOrdersFormated');
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
