<?php

App::uses('AppModel', 'Model');

class WebixCustomer extends AppModel {

    public $useTable = 'customers'; // No bo to tylko wrap dla Webix'a

    public $hasOne = [
        'WebixAdresSiedziby' => [            
            'foreignKey' => 'customer_id',
            'dependent' => true           
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
        ],
        'WebixPrivateOrder' => [            
            'foreignKey' => 'customer_id',            
            'fields'  => [
                'WebixPrivateOrder.id'
                ,'WebixPrivateOrder.status'
            ],
            'conditions' => ['WebixPrivateOrder.status' => 0],   
            'dependent' => true      
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
            'WebixCustomer.forma_zaliczki', 'WebixCustomer.procent_zaliczki',
            'WebixCustomer.forma_platnosci', 'WebixCustomer.termin_platnosci',
            'WebixCustomer.waluta', 'WebixCustomer.cr', 'WebixCustomer.etylang',
            'WebixCustomer.comment',
            'WebixCustomerRealOwner.id', 'WebixCustomerRealOwner.name', 'WebixCustomerRealOwner.inic',
            'WebixAdresSiedziby.id', 'WebixAdresSiedziby.name', 'WebixAdresSiedziby.ulica',
            'WebixAdresSiedziby.nr_budynku', 'WebixAdresSiedziby.kod',
            'WebixAdresSiedziby.miasto', 'WebixAdresSiedziby.kraj'
        ]
    ];

    //public $defaultConditions = [ 'WebixPrivateOrder.status' => 0 ]; // myk w AppModel z beforeFind

    /**
     * Karający mustafę skrypt, który wynajduje nam klientów których mozna usunąć,
     * czyli takich, którzy nie mają żadnych zamówień lub co najwyzej prywatne */
    private $theSql =
        "SELECT WebixCustomer.id, WebixCustomer.name, WebixCustomer.osoba_kontaktowa,
        WebixCustomerRealOwner.id, WebixCustomerRealOwner.name, WebixCustomerRealOwner.inic,
        WebixAdresSiedziby.id, WebixAdresSiedziby.name, WebixAdresSiedziby.ulica, WebixAdresSiedziby.nr_budynku,
        WebixAdresSiedziby.kod, WebixAdresSiedziby.miasto
        FROM `customers` AS WebixCustomer
        JOIN `users` AS WebixCustomerRealOwner ON WebixCustomerRealOwner.id=WebixCustomer.opiekun_id
        JOIN `addresses` AS WebixAdresSiedziby ON WebixAdresSiedziby.customer_id=WebixCustomer.id
        WHERE WebixCustomer.id NOT IN 
        (SELECT DISTINCT orders.customer_id FROM `orders` WHERE orders.status>0)";    
    

    // Szukanie - 30ms na moim kompie
    public function getKosz( $theOwnerId = 0, $coSzukamy = null ) {

        if( $theOwnerId ) { // różne od zera, znaczy chcemy wyniki dla konkretnego usera
            $this->theSql .= " AND WebixCustomerRealOwner.id=$theOwnerId";
        }
        if( $coSzukamy != '' AND $coSzukamy != null ) { //niepusta fraza (nie wiem czemu oba warunki, ale od przybytku głowa nie boli)
            $this->theSql .= " AND WebixCustomer.name LIKE '%$coSzukamy%'";
        }
        $start = microtime(true);        
        $sqlResult = $this->query($this->theSql);      
        $findTime = microtime(true) - $start;  
        return [
            'findTime' => $findTime,
            'records' => $this->transferResults( $sqlResult, $coSzukamy ),
            'sqlResult' => $sqlResult
        ];        
    }
    
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
        $tmp["WebixCustomer"]["howManyPrivateOrders"] = count($tmp["WebixPrivateOrder"]);
        $tmp["WebixCustomer"]["forma_zaliczki_txt"] = $this->bazaFormaZal2viewFormat($tmp["WebixCustomer"]["forma_zaliczki"]);
        $tmp["WebixCustomer"]["forma_platnosci_txt"] = $this->bazaFormaZal2viewFormat($tmp["WebixCustomer"]["forma_platnosci"]);
        $tmp["WebixCustomer"]["etylang_txt"] = $this->etyk_view["etylang"]["cview"][$tmp["WebixCustomer"]["etylang"]];
        $tmp["WebixCustomer"]["comment"] = nl2br($tmp["WebixCustomer"]["comment"]);
        
        $merged = $this->mergeCakeData($tmp); 

        /** >>>>>>>>
         * Debug purposes. Uset bo (na razie) nie potrzebujemy rekordów dot. zamówień. Potrzebujemy tylko ich ilość,
         * stą count powyżej. Nie ma więc sensu przesyłanie np. 900+ rekordów dla klienta nr 3 */
        unset($merged["WebixNonPrivateOrder"]);
        unset($merged["WebixPrivateOrder"]);
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
    public function getMany( $coSzukamy = null, $realOwner = 0, $limit = 17) {

        $parameters = [
            'fields'    => $this->fieldsWeWant['list'],
            'limit'     => $limit
        ];        

        if( $realOwner ) {           
            $parameters['conditions']['WebixCustomerRealOwner.id'] = $realOwner;
        }

        if( $coSzukamy != '' AND $coSzukamy != null ) { //niepusta fraza
            $parameters['conditions']['WebixCustomer.name LIKE'] = '%'.$coSzukamy.'%';
        }
        $start = microtime(true);
        $cakeResults = $this->find('all', $parameters);   
        $findTime = microtime(true) - $start;        
        return [
            'findTime' => $findTime,            
            'records' =>  $this->transferResults($cakeResults, $coSzukamy),            
            'cake'  => $cakeResults,
        ];
    }    

    /**
     * Przekonvertuj do Webixa i wstaw span'y do wyników, które otoczą frazę */
    private function transferResults( $dane = [], $fraza = "", $kosz = false  ) {
        
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