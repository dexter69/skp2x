<?php

App::uses('AppModel', 'Model');

class WebixCustomer extends AppModel {

    public $useTable = 'customers'; // No bo to tylko wrap dla Webix'a

    private $fieldsWeWant = [ // za wyjątkiem $hasMany
        'WebixCustomer.id', 'WebixCustomer.name', 'WebixCustomer.osoba_kontaktowa',
        'WebixCustomerRealOwner.id', 'WebixCustomerRealOwner.name', 'WebixCustomerRealOwner.inic'
        
    ];

    //public $defaultConditions = [ 'WebixPrivateOrder.status' => 0 ]; // myk w AppModel z beforeFind

    public $belongsTo = [
        'WebixCustomerRealOwner' => [ // Stały opiekun klienta
            'foreignKey' => 'opiekun_id',            
        ]
    ];

    /**
     *  Znajdż klientów na potrzeby dodania zamówienia handlowego
     *  $constantOwner - stały opiekun klienta - opiekun_id w tabeli customers
     *  $constantOwner = 0, znajdź wszystkich klientów, użytkownik dowolny
     *  $realOwner > 0, to znajdź klientów tylko tego użytkownika
     *  $limit - ile max rekordów */
    public function getCustomersForAddingAnOrder( $coSzukamy = null, $realOwner = 0, $limit = 11 ) {

        $out = [];
        $parameters = [
            'fields' => $this->fieldsWeWant,
            'limit' => $limit
        ];

        if( $realOwner ) {           
            $parameters['conditions']['WebixCustomerRealOwner.id'] = $realOwner;
        }

        if( $coSzukamy != '' AND $coSzukamy != null ) { //niepusta fraza
            $parameters['conditions']['WebixCustomer.name LIKE'] = '%'.$coSzukamy.'%';
        }

        $cakeResults = $this->find('all', $parameters);        
        $out['records'] = $this->mergeCakeManyRows( $cakeResults );
        $out['cake'] = $cakeResults; // w celach diagnostycznych
        return $out;
    }

}