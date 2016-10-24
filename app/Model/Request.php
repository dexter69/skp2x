<?php

/* To ma być nowy model operujący na tablicy orders dla celów obsługi druku etykiet.
 * Po prostu chcemy czysty kod */

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
