<?php

/*  To ma być nowy model operujący na tablicy orders dla celów zrobienia lebszego listingu
 *  i wyszukiwania handlowych. Oraz obsługi etykiet. Oraz nowe Dodawanie/Edytowanie zamówienia - test WEBIX
 *  Po prostu chcemy czysty kod */

App::uses('AppModel', 'Model');

class Request extends AppModel {
    
    public $useTable = 'orders';
   
    public $hasMany = array(
        'Ticket' => array(
            'fields' => array('Ticket.id', 'Ticket.name', 'Ticket.ilosc', 'Ticket.mnoznik')
        )       
    );
    
    public $belongsTo = 'User';

    
    
}
