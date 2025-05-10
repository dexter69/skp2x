<?php
App::uses('AppModel', 'Model');

/**
 * Gropup Model
 * 
 * @property User $User
*/

class Group extends AppModel {

    /**
     * hasMany associations
     *
     * @var array
     */

    public $hasMany = array(
        'Permission' => array(
            'className' => 'Permission',
            'foreignKey' => 'group_id',
            'dependent' => true
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'group_id'
        )
    );


}

