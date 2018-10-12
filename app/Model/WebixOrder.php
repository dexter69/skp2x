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

    private $searchConditions = [
        'fields' => [
            'id', 'user_id', 'customer_id', 'nr', 'stop_day', 'created',
            'WebixCustomer.id', 'WebixCustomer.name', 'WebixCustomer.email',
            'WebixOrderCreator.id', 'WebixOrderCreator.name', 'WebixOrderCreator.inic'
        ],
        'conditions' => ['WebixOrder.status' => 0]//, 'WebixOrder.user_id <' => 10] 
        ,'order' => 'WebixOrder.id DESC'           
    ];

    public function getAllPrivateOrders( $idHandlowca = 0 ) {

        if( $idHandlowca ) {
            // Mamy $id Handlowca - szukamy tylko dla tego Handlowca => trzeba dorzucić warunek
            //$searchParams['conditions']['WebixOrder.user_id'] = $idHandlowca;
            $this->searchConditions['conditions']['WebixOrder.user_id'] = $idHandlowca;
        }

        //return $this->find('all', $searchParams);        
        return $this->find('all', $this->searchConditions);   
    }

    /*
        Potrzebujemy znaleź po Imieniu Handlowca - "name". Wypróbujemy też cake'owe magic findBy */
    public function getAllPrivateOrdersByUserName( $imieHandlowca = NULL ) {

        if( $imieHandlowca != "" && $imieHandlowca != NULL ) {
            // Mamy imię Handlowca - szukamy tylko dla tego Handlowca => trzeba dorzucić warunek            
            $this->searchConditions['conditions']['WebixOrderCreator.name'] = $imieHandlowca;
        } 
        return $this->find('all', $this->searchConditions);   
    }

}