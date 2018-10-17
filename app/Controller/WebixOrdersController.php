<?php
App::uses('AppController', 'Controller');
/*
*   1.10.2018
*   Kontroler dedykowany do zamówień dla Webix
*/

class WebixOrdersController extends AppController {

    /*
    Czyje prywatne chcemy?  */    

    public function getPrivateOrders( $idOpiekuna = 0) {

        //$theOrders = $this->WebixOrder->getAllPrivateOrders( $idOpiekuna );
        $theOrdersFormated['records'] = $this->formatForWebix(
            $this->WebixOrder->getAllPrivateOrders( $idOpiekuna )
        );
        $theOrdersFormated['peopleHavingPrivs'] = [
            ['id'=>0, 'value'=>"Wszyscy"],
            ['id'=>1, 'value'=>"Darek"],
            ['id'=>2, 'value'=>"Beata"],
            ['id'=>3, 'value'=>"Agnieszka"],
            ['id'=>10, 'value'=>"Renata"],
            ['id'=>11, 'value'=>"Marzena"]
            ,            ['id'=>31, 'value'=>"Piotr"]
        ];
        //$theOrdersFormated = [ 'idOpiekuna' => $idOpiekuna ];
        $this->set(compact(['theOrdersFormated']));
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
    
}
