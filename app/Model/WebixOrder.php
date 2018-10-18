<?php

App::uses('AppModel', 'Model');

class WebixOrder extends AppModel {

    public $useTable = 'orders'; // No bo to tylko wrap dla Webix'a

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

}