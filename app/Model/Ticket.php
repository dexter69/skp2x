<?php

/* To ma być nowy model operujący na tablicy cardss dla celów obsługi druku etykiet.
 * Po prostu chcemy czysty kod */
App::uses('AppModel', 'Model');

class Ticket extends AppModel {
    
    public $useTable = 'cards';
    
    public $belongsTo = array(
        'Request' => array('foreignKey' => 'order_id'),
        'Task' => array('foreignKey' => 'job_id')
    );
    
    /* chcemy się dowiedzieć jaki ma nr handlowe, do którego potpieta jest karta o danym id */
    public function getNrHandlowgo($id) {
        
        if( $id > 0 ) {            
            $dane = $this->find('first', array(
                'conditions' => array('Ticket.id' => $id),
                'fields' => array('order_id')
            ));
            $rec = $this->Request->find('first', array(
                'conditions' => array('Request.id' => $dane['Ticket']['order_id']),
                'fields' => array('nr', 'User.id', 'User.inic')
            ));            
            return $this->bnr2nrh2($rec['Request']['nr'], $rec['User']['inic'], false);
        }
        return $id;
    }
}
