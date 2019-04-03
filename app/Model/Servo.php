<?php

/*  To ma być nowy model operujący na tablicy orders dla celów zrobienia lebszego listingu
 *  i wyszukiwania handlowych. Oraz obsługi etykiet. Oraz nowe Dodawanie/Edytowanie zamówienia - test WEBIX
 *  Po prostu chcemy czysty kod */

App::uses('AppModel', 'Model');

class Servo extends AppModel {
    
    public $useTable = 'orders';

    public $fieldsWeWant = [ // za wyjątkiem $hasMany => to mamy w relacji
        'Servo.id', 'Servo.status',
    ]; 
   
    public $hasMany = array(
        /*
        'Card' => array(
            //'foreignKey' => 'order_id',
            'fields' => array('Card.id', 'Card.name', 'Card.status', 'Card.left')
        ),
        */
        // Tylko te karty tego zamówienia, które są na magazynie
        'ServoCard' => [
            'fields' => ['ServoCard.id', //'ServoCard.name',
             'ServoCard.status'//, 'ServoCard.left'
            ],
            'conditions' => ['ServoCard.left >' => 0],  
        ],
        'Event' => [
            'foreignKey' => 'order_id'
        ]
    );    
    
}