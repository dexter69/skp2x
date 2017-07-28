<?php

/* To ma być nowy model operujący na tablicy cardss dla celów Special Search.
 * Po prostu chcemy czysty kod */
 
App::uses('AppModel', 'Model');

class Ticket extends AppModel {

    public $useTable = 'cards';

}