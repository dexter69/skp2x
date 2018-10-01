<?php

App::uses('AppModel', 'Model');

class WebixOrder extends AppModel {

    public $useTable = 'orders'; // No bo to tylko wrap dla Webix'a

    public function getAllPrivateOrders( $idHandlowca = 0 ) {

        $searchParams = [
            'fields' => ['id', 'user_id', 'nr', 'status'],
            'conditions' => ['WebixOrder.status' => 0]
        ];

        if( $idHandlowca ) {
        // Mamy $id Handlowca - szukamy tylko dla tego Handlowca => trzeba dorzucić warunek
            $searchParams['conditions']['WebixOrder.user_id'] = $idHandlowca;
        }

        return $this->find('all', $searchParams);        
    }

}