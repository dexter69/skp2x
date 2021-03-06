<?php

/*
Zamówienie prywatne (status=0) */

App::uses('AppModel', 'Model');

class WebixPrivateOrder extends AppModel {

    public $useTable = 'orders'; // No bo to tylko wrap dla Webix'a

    public $defaultConditions = [ 'WebixPrivateOrder.status' => 0 ]; // myk w AppModel z beforeFind
    
    /**
     * Olewamy tu $defaultFields - nie działa do końca dobrze. Wygląda na to, że aby otrzymać tylko te pola,
     * które chcemy, to (jak tu poniżej) dla $hasMany musi być zdefiniowane w relacji
     * a pozostałe jako parametry wyszukiwania
     */

    private $fieldsWeWant = [ // za wyjątkiem $hasMany => to mamy w relacji
        'WebixPrivateOrder.id', 'WebixPrivateOrder.nr', 'WebixPrivateOrder.stop_day',
        'WebixPrivateOrderOwner.id', 'WebixPrivateOrderOwner.name', 'WebixPrivateOrderOwner.inic',
        'WebixCustomer.id', 'WebixCustomer.name', 'WebixCustomer.email'
    ];    

    public $hasMany = [
        'WebixCard' => [            
            'foreignKey' => 'order_id',            
            'fields'  => [
                'WebixCard.id', 'WebixCard.name'
            ]            
        ]
    ];

    public $belongsTo = [
        'WebixPrivateOrderOwner' => [ // Właściciel zamówienia, użytkownik, który opiekuje się nim
            'foreignKey' => 'user_id',            
        ],
        'WebixCustomer' => [ // Klient, który zlecił to zamówienie
            'foreignKey' => 'customer_id',            
        ]
    ];    

    public function getTheOrders( $idHandlowca = 0 ) {

        $cakeResults = $this->find('all', ['fields' => $this->fieldsWeWant] );
        $out = $this->transformResultsForWebix( $idHandlowca, $cakeResults );
        $out['cake'] = $cakeResults; // w celach diagnostycznych
        return $out;
    }

    private function transformResultsForWebix( $idLudzika = 0, $in = [] ) {

        $out = [];
        $ludziki[0] = "Wszyscy"; // ludziki do filtra
        foreach( $in as $row ) { 
            $id = $row['WebixPrivateOrderOwner']['id'];            
            $ludziki[ $id ] = $row['WebixPrivateOrderOwner']['name'];
            if( !$idLudzika || $id == $idLudzika )   {
                $nr = $this->makeItSafe( $row['WebixPrivateOrder'], 'nr', false);
                $inic = $this->makeItSafe( $row['WebixPrivateOrderOwner'], 'inic', null);
                // Wirtualne pola
                $row['WebixPrivateOrder']['nrTxt'] = $this->bnr2nrh2($nr, $inic, false); // ludzki nr handlowy       
                $row['WebixPrivateOrder']['ileKart'] = count($row['WebixCard']); // liczymy ile jest kart
                $out[] = $this->mergeCakeData($row);            
            }
        }
        ksort($ludziki); // sortujemy, żeby mieć wg id ludzika
        $peopleHavingPrivs = []; // ludziska, którzy mają jakieś prywatne zamówienia                        
        foreach( $ludziki as $id => $value ) {
            $peopleHavingPrivs[] = ['id' => $id, 'value' => $value ];
        }
        return [                
            'records' => $out,
            'peopleHavingPrivs' => $peopleHavingPrivs
        ];        
    }

    private function makeItSafe( $table, $indeks, $thatIfNot ) {

        return isset( $table[$indeks] ) ? $table[$indeks] : $thatIfNot;
    }    

}
