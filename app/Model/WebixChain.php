<?php

App::uses('AppModel', 'Model');

class WebixChain extends AppModel {

    public $useTable = 'chains'; // No bo to tylko wrap dla Webix'a


    /**
     * Zarezerwuj w bazie dostępny łańcuch/kod linku dla klienta o id = $customerId
     */
    public function reserveChain($customerId = 0) {

        $freeChain = $this->find('first',[
            'fields' => ['id', 'chain', 'customer_id'],
            'conditions' => [
                'customer_id' => 0
            ]
        ]);
        $freeChain["WebixChain"]["customer_id"] = $customerId;
        $freeChain['result'] = $this->save($freeChain);
        return $freeChain;
    }

}