<?php

App::uses('AppModel', 'Model');

class WebixOrder extends AppModel {

    public $useTable = 'orders'; // No bo to tylko wrap dla Webix'a

    private $fieldsWeWant = [ // za wyjątkiem $hasMany => to mamy w relacji
        'WebixOrder.id', 'WebixOrder.nr', 'WebixOrder.stop_day',
        //'WebixPrivateOrderOwner.id', 'WebixPrivateOrderOwner.name', 'WebixPrivateOrderOwner.inic',
        //'WebixCustomer.id', 'WebixCustomer.name', 'WebixCustomer.email'
    ];  

    public $hasMany = [
        'WebixCard' => [            
            'foreignKey' => 'order_id',            
            'fields'  => [
                'WebixCard.id', 'WebixCard.name'
            ]            
        ]
    ];

    // Weź wesję szczupłą    
    public function getTheOrderLight( $id=0 ) {

        return $this->find('first', [
                'conditions' => ['id' => $id],
                'fields' => $this->fieldsWeWant
            ]
        );
    }

    // Chwilowo
    /* 
    public $belongsTo = [
        'WebixCustomer' => [
            'foreignKey' => 'customer_id',
            'fields' => [
                'WebixCustomer.id',
                'WebixCustomer.opiekun_id',
                'WebixCustomer.name',
                'WebixCustomer.email'
            ]
        ]
    ];  
    */  

}