<?php 
/**
 *  Użytkownik, który jest stałym opiekunem klienta
 * - opiekun_id w tabeli customers */

App::uses('AppModel', 'Model');

class CustomerRealOwner extends AppModel {

    public $useTable = 'users'; // No bo to tylko wrap 

}