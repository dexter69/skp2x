<?php
App::uses('AppModel', 'Model');

class Disposal extends AppModel {
    
    public $useTable = 'orders';

    public $hasMany = array(        
        'Badge' => array(
            'fields' => array('Badge.id')
        )        
    );
}
