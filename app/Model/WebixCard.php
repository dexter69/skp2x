<?php
/**
 * Model kart dla Webix'a
 */
App::uses('AppModel', 'Model');

class WebixCard extends AppModel {

    public $useTable = 'cards'; // No bo to tylko wrap dla Webix'a
    /*
    public $defaultFields = [
        'WebixCard.id', 'WebixCard.name'
    ];
    
    public $belongsTo = [
        'WebixPrivateOrder' => [ 
            //'className' => 'WebixPrivateOrder',
            'foreignKey' => 'order_id'
        ]
    ];
    */
}
