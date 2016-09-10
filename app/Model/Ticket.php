<?php

/* To ma być nowy model operujący na tablicy cardss dla celów obsługi druku etykiet.
 * Po prostu chcemy czysty kod */
App::uses('AppModel', 'Model');

/**
 * CakePHP Ticket
 * @author dexter
 */
class Ticket extends AppModel {
    
    public $useTable = 'cards';
    
    public $belongsTo = 'Task';
}
