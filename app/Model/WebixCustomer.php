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
     *  $constantOwner > 0, to znajdź klientów tylko tego użytkownika */
    public function getCustomersForAddingAnOrder( $constantOwner = 0 ) {

        $out = [];
        $parameters = [
            'fields' => $this->fieldsWeWant,
            'limit' => 10
        ];

        if( $constantOwner ) {
            $parameters['conditions'] = ['WebixConstantCustomerOwner.id' => $constantOwner];
        }

        $cakeResults = $this->find('all', $parameters);        
        $out['results'] = $this->mergeCakeManyRows( $cakeResults );
        $out['cake'] = $cakeResults; // w celach diagnostycznych
        return $out;
    }

}