<?php

/*
Użytkownik, który posiada przynajmniej jedno zamówienie prywatne */

App::uses('AppModel', 'Model');

class WebixPrivateOrderOwner extends AppModel {

    public $useTable = 'users'; // No bo to tylko wrap dla Webix'a

    /* To nie działa, dobrze, zostawiam w celach edukacyjnych
        public $defaultConditions = [ 'status' => 0 ]; // myk w AppModel z beforeFind 
        TRZEBA jeszcze sprawdzić z WebixPrivateOrder
        */

    public $hasMany = [
        'WebixPrivateOrder' => [
            'foreignKey' => 'user_id',
            'conditions' => ['WebixPrivateOrder.status' => 0]        
        ]
    ];
}