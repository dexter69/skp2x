<?php

/*
Zamówienie prywatne (status=0) */

App::uses('AppModel', 'Model');

class WebixPrivateOrder extends AppModel {

    public $useTable = 'orders'; // No bo to tylko wrap dla Webix'a

    public $defaultConditions = [ 'WebixPrivateOrder.status' => 0 ]; // myk w AppModel z beforeFind

    public $defaultFields = [ 
        'WebixPrivateOrder.id', 'WebixPrivateOrder.nr', 'WebixPrivateOrder.stop_day',
        'WebixPrivateOrderOwner.id', 'WebixPrivateOrderOwner.name', 'WebixPrivateOrderOwner.inic',
        'WebixCustomer.id', 'WebixCustomer.name', 'WebixCustomer.email'
    ];

    public $belongsTo = [
        'WebixPrivateOrderOwner' => [ // Właściciel zamówienia, użytkownik, który opiekuje się nim
            'foreignKey' => 'user_id'
        ],
        'WebixCustomer' => [ // Klient, który zlecił to zamówienie
            'foreignKey' => 'customer_id'            
        ]
    ];

    private $OwnerOfTheOrderFieldNameInDb = "WebixPrivateOrder.user_id"; // Gdybyśmy w przyszłosci przeszli na inne pole

    public function getAllOrders( $idHandlowca = 0 ) {

        if( 0 && $idHandlowca ) { // to szukamy tylko dla niego
            $this->defaultConditions[ $this->OwnerOfTheOrderFieldNameInDb ] = $idHandlowca;
        }
        return $this->transformResultsForWebix( $idHandlowca, $this->find('all') );    //, false);
    }

    private function transformResultsForWebix( $opiekunId = 0, $in = [], $transform = true ) {
        // $opiekunId - opiekun zamówienia, gdy = 0, to interesują nas wszyscy
        // $in - wejściowa tablica z wynikami w formacie Cake'a
        // $transform domyśllnie transformujemy, ale możemy w celach diagnostycznych chcieć zobaczyć nietransformowaną

        if( $transform && !empty($in) ) {

            $records = [];            
            $ludziki[0] = "Wszyscy"; // ludziki do filtra
            foreach( $in as $row ) {   
                $outRow = $this->transformOneResult( $opiekunId, $row );
                if( !empty($outRow) ) {                  
                    $records[] = $outRow;
                }
                $ludziki[ $row['WebixPrivateOrderOwner']['id'] ] = $row['WebixPrivateOrderOwner']['name'];                
            }
            ksort($ludziki); // sortujemy, żeby mieć wg id ludzika

            $peopleHavingPrivs = []; // ludziska, którzy mają jakieś prywatne zamówienia                        
            foreach( $ludziki as $id => $value ) {
                $peopleHavingPrivs[] = ['id' => $id, 'value' => $value ];
            }
            ksort($ludziki);
            return [                
                'records' => $records,
                'peopleHavingPrivs' => $peopleHavingPrivs
            ];
        }
        return $in;
    }

    // Transformuje jeden rekord, $ludzikId - id opiekuna zamówienia - transformujemy tylko gdy id użytkownika jest właśnie takie
    private function transformOneResult( $ludzikId = 0, $row = [] ) {

        $retRow = [];
        if( $ludzikId == $row['WebixPrivateOrderOwner']['id'] || !$ludzikId ) {            
            $retRow['WebixPrivateOrder.id'] = $row['WebixPrivateOrder']['id'];                
            $retRow['WebixPrivateOrder.nr'] = $row['WebixPrivateOrder']['nr'];
            if( $retRow['WebixPrivateOrder.nr'] ) { // Mimo, ze to prywatne, niektóre mają numery
                $retRow['WebixPrivateOrder.nrTxt'] = 
                $this->bnr2nrh2($retRow['WebixPrivateOrder.nr'], $row['WebixPrivateOrderOwner']['inic'], false);
            } else {
                $retRow['WebixPrivateOrder.nrTxt'] = null;
            }
            $retRow['WebixPrivateOrder.stop_day'] = $row['WebixPrivateOrder']['stop_day'];

            $retRow['WebixCustomer.name'] = $row['WebixCustomer']['name'];
            $retRow['WebixCustomer.email'] = $row['WebixCustomer']['email'];
            $retRow['WebixPrivateOrderOwner.name'] = $row['WebixPrivateOrderOwner']['name'];     
        }       
        return $retRow;
    }

}
