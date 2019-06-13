<?php

/*
*   7.03.2019
    Wykorzystujemy ten kontroler zamiast OrdersController
    dla obsługi zamówień serwisoowych. Tam już duzo kodu jest...
*/

App::uses('AppController', 'Controller');

class ServosController extends AppController {       
    
    /**
		 * Ajax - serwisowe otwieranie zamówień	 */

    public function servo() {

    $start = microtime(true);//time();
    //round(microtime(true) * 1000);

    // Nie chcemy w find mieć zdarzeń tego zamówienia
    $this->Servo->unbindModel([
        'hasMany' => ['Event']
    ]);
    $ord = $this->Servo->find('first', [
        'conditions' => [
            'id' => $this->request->data['id']
        ],
        'fields' => $this->Servo->fieldsWeWant
    ]);
    //sleep(1);

    // Konstruujemy zdarzenie dla otwarcia zamówienia    
    $ord['Event'] = [
        [
            'user_id' => $this->Auth->user('id'),
            'order_id' => $this->request->data['id'],
            'co' => servopen,
            'sent' => true, // na razie nie bedziemy się bawic z tym w powiadomienia
        ]
    ];
    
    $answer = [
        //'zamPlusKarty' => $ord,           
        //'czas' => (microtime(true)-$start)*1000 . " ms",				
        //'rq' => $this->request->data,
        'success' => $this->servoOpen($ord),
        //'event' => $event
    ];

    $this->set(array(
        'answer' => $answer,
        '_serialize' => 'answer' //to używamy, gdy nie chcemy view
    ));            
    }

    
    private function servoOpen( $orderAndItsCards = []) {

        $orderAndItsCards['Servo']['status'] = 0;    
   
        $len = count($orderAndItsCards['ServoCard']);
        for($i=0; $i<$len; $i++) {
            $orderAndItsCards['ServoCard'][$i]['status'] = 0;
        }
        return $this->Servo->saveAssociated($orderAndItsCards);
    }
    
    
}