<?php

App::uses('AppModel', 'Model');

class WebixOrder extends AppModel {

    public $useTable = 'orders'; // No bo to tylko wrap dla Webix'a

    public function getAllPrivateOrders( $idHandlowca = 0 ) {

        if( $idHandlowca ) { // Mamy $id Handlowca - szukamy tylko dla tego Handlowca
            $prywatne = $this->find('all', array(
                'conditions' => array('WebixOrder.status' => 0, 'WebixOrder.user_id' => $idHandlowca)
            ));
        } else { // Szykamy wszystkich prywatnych
            $prywatne = $this->find('all', array(
                'conditions' => array('WebixOrder.status' => 0)
            ));
        }     
        return $prywatne;
    }

}