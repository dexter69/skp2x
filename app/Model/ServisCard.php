<?php
/**
 * Model kart, które są serwisowane
 */
App::uses('AppModel', 'Model');

class ServisCard extends AppModel {

    public $useTable = 'cards'; // No bo to tylko wrap 
    

    public function beforeFind($queryData = array()) {

        $queryData['conditions']['ServisCard.serwis'] = 1;

        return $queryData;
    }
    
}