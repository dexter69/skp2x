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
        $theOrdersFormated = $this->formatForWebix($theOrders);
        
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
            [ 'id'=>1, 'orderId'=> 9946, 'costomerName'=>"Klient 1",  'termin'=> '29 XI 2018', 'status'=> 'PRYWATNE'],
            [ 'id'=>2, 'orderId'=> 2569, 'costomerName'=>"The Godfather jest słaby",             'termin'=> '19 XI 2018', 'status'=> 'PRYWATNE'],
            [ 'id'=>3, 'orderId'=> 6974, 'costomerName'=>"Multiklient",    'termin'=> '15 XI 2018', 'status'=> 'PRYWATNE'],
            [ 'id'=>4, 'orderId'=> 3994, 'costomerName'=>"Pulp friction klient",              'termin'=> '23 XI 2018', 'status'=> 'PRYWATNE']
        ];

        $this->set(compact('prywatneZamowienia'));
        $this->set('_serialize', 'prywatneZamowienia');
    }
}
