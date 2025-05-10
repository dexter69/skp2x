<?php
App::uses('AppModel', 'Model');

/**
 * Permission Model
 * 
 * @property Group $Group
*/

class Permission extends AppModel {

    /**
     * belongsTo associations
     *
     * @var array
     */

    public $belongsTo = array(
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id'
        )
    );
}