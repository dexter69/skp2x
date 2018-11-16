<?php

App::uses('AppModel', 'Model');

class WebixCustomer extends AppModel {

    public $useTable = 'customers'; // No bo to tylko wrap dla Webix'a

    public $hasOne = [
        'WebixAdresSiedziby' => [            
            'foreignKey' => 'customer_id'            
        ]
    ];

    public $hasMany = [
        'WebixNonPrivateOrder' => [            
            'foreignKey' => 'customer_id',            
            'fields'  => [
                'WebixNonPrivateOrder.id'
                //, 'WebixNonPrivateOrder.nr', 'WebixNonPrivateOrder.status'
            ],
            'conditions' => ['WebixNonPrivateOrder.status !=' => 0],         
        ]
    ];

    public $belongsTo = [
        'WebixCustomerRealOwner' => [ // Stały opiekun klienta
            'foreignKey' => 'opiekun_id',            
        ]
    ];

    private $fieldsWeWant = [
        'list' => [ // Do listy klientów przy dodawaniu zamówienia
            // za wyjątkiem $hasMany
            'WebixCustomer.id', 'WebixCustomer.name', 'WebixCustomer.osoba_kontaktowa',
            'WebixCustomerRealOwner.id', 'WebixCustomerRealOwner.name', 'WebixCustomerRealOwner.inic',
            'WebixAdresSiedziby.id', 'WebixAdresSiedziby.name', 'WebixAdresSiedziby.ulica',
            'WebixAdresSiedziby.nr_budynku', 'WebixAdresSiedziby.kod', 'WebixAdresSiedziby.miasto'
        ],
        'one' => [ // just one customer
            'WebixCustomer.id', 'WebixCustomer.name',
            'WebixCustomer.osoba_kontaktowa', 'WebixCustomer.email', 'WebixCustomer.vatno_txt',
            'WebixCustomerRealOwner.id', 'WebixCustomerRealOwner.name', 'WebixCustomerRealOwner.inic',
            'WebixAdresSiedziby.id', 'WebixAdresSiedziby.name', 'WebixAdresSiedziby.ulica',
            'WebixAdresSiedziby.nr_budynku', 'WebixAdresSiedziby.kod',
            'WebixAdresSiedziby.miasto', 'WebixAdresSiedziby.kraj'
        ]
    ];

    //public $defaultConditions = [ 'WebixPrivateOrder.status' => 0 ]; // myk w AppModel z beforeFind
    

    /*
        Chcemy ifo o jednym kliencie dla szybkiego dodania zamówienia  */
    public function getOne( $id = 0 ) {

        $parameters = [
            'fields' => $this->fieldsWeWant['one'],
            'conditions' => [
                "WebixCustomer.id" => $id
            ]
        ];
        //$cakeResults = 
        $tmp = $this->find('first', $parameters);
        $tmp["WebixCustomer"]["howManyNonPrivateOrders"] = count($tmp["WebixNonPrivateOrder"]);
        $merged = $this->mergeCakeData($tmp); 

        /** >>>>>>>>
         * Debug purposes. Uset bo (na razie) nie potrzebujemy rekordów dot. zamówień. Potrzebujemy tylko ich ilość,
         * stą count powyżej. Nie ma więc sensu przesyłanie np. 900+ rekordów dla klienta nr 3 */
        unset($merged["WebixNonPrivateOrder"]);
        /*$merged["cake"] = $cakeResults;
        * Debug <<<<<<<<<< */
        return $merged;
    }

    /**
     *  Znajdż klientów na potrzeby dodania zamówienia handlowego
     *  $constantOwner - stały opiekun klienta - opiekun_id w tabeli customers
     *  $constantOwner = 0, znajdź wszystkich klientów, użytkownik dowolny
     *  $realOwner > 0, to znajdź klientów tylko tego użytkownika
     *  $limit - ile max rekordów */
    public function getMany( $coSzukamy = null, $realOwner = 0, $limit = 11 ) {

        $out = [];
        $parameters = [
            'fields' => $this->fieldsWeWant['list'],
            'limit' => $limit
        ];

        if( $realOwner ) {           
            $parameters['conditions']['WebixCustomerRealOwner.id'] = $realOwner;
        }

        if( $coSzukamy != '' AND $coSzukamy != null ) { //niepusta fraza
            $parameters['conditions']['WebixCustomer.name LIKE'] = '%'.$coSzukamy.'%';
        }

        $cakeResults = $this->find('all', $parameters);        
        $out['records'] = $this->transferResults($cakeResults, $coSzukamy);// $this->mergeCakeManyRows( $cakeResults );
        $out['cake'] = $cakeResults; // w celach diagnostycznych
        return $out;
    }

    /**
     * Przekonvertuj do Webixa i wstaw span'y do wyników, które otoczą frazę */
    private function transferResults( $dane = [], $fraza = "" ) {
        
        $out = [];
        $start = "<span class='gruby'>";
        $stop = "</span>";
        foreach( $dane as $oneRow ) {            
            $newRow = $this->mergeCakeData($oneRow);            
            if( $fraza ) {
                $pos = stripos($newRow["WebixCustomer_name"], $fraza);
                $frag = substr($newRow["WebixCustomer_name"], $pos, strlen($fraza));                
                $newRow["WebixCustomer_name"] = str_ireplace($fraza, "$start$frag$stop", $newRow["WebixCustomer_name"]);
            }
            // ile klient ma NIE prywatnych zamówień            
            if( array_key_exists("WebixNonPrivateOrder", $newRow) ) {
                $newRow["WebixCustomer_howManyNonPrivateOrders"] = count($newRow["WebixNonPrivateOrder"]);
            } else {
                $newRow["WebixCustomer_howManyNonPrivateOrders"] = 0;
            }            
            unset($newRow["WebixNonPrivateOrder"]); // Na razie nie potrzebujemy tych danych         
            $out[] = $newRow;
        }
        return $out;
    }

}