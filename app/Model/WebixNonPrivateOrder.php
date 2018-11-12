<?php

/*
Zamówienie NIE prywatne (status != 0) */

App::uses('AppModel', 'Model');

class WebixNonPrivateOrder extends AppModel {

    public $useTable = 'orders'; // No bo to tylko wrap dla Webix'a

    /* public $defaultConditions = [ 'WebixNonPrivateOrder.status !=' => 0 ]; // myk w AppModel z beforeFind
        Nie działa dobrze*/
    
}