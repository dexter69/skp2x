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
        ],
        'WebixOrderCreator' => [
            'foreignKey' => 'user_id',
            'fields' => [
                'WebixOrderCreator.id',
                'WebixOrderCreator.name',
                'WebixOrderCreator.inic',
                'WebixOrderCreator.dzial'
            ]
        ]
    ];

    public function getAllPrivateOrders( $idHandlowca = 0 ) {

        $searchParams = [
            'fields' => [
                'id', 'user_id', 'customer_id', 'nr', 'stop_day', 'created',
                'WebixCustomer.id', 'WebixCustomer.name', 'WebixCustomer.email',
                'WebixOrderCreator.id', 'WebixOrderCreator.name', 'WebixOrderCreator.inic'
            ],
            'conditions' => ['WebixOrder.status' => 0]//, 'WebixOrder.user_id <' => 10] 
            ,'order' => 'WebixOrder.id DESC'           
        ];

        if( $idHandlowca ) {
            // Mamy $id Handlowca - szukamy tylko dla tego Handlowca => trzeba dorzucić warunek
            $searchParams['conditions']['WebixOrder.user_id'] = $idHandlowca;
        }

        return $this->find('all', $searchParams);        
    }

}