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
            $rq = $this->Servo->find('first', [
                'conditions' => [
                    'id' => $this->request->data['id']
                ],
                'fields' => $this->Servo->fieldsWeWant
            ]);
			//sleep(1);
			$test = [
                'sdg' => $rq,                
				'czas' => (microtime(true)-$start)*1000 . " ms",				
				'rq' => $this->request->data
			];
			
			$this->set(array(
                'answer' => $test,
                '_serialize' => 'answer' //to używamy, gdy nie chcemy view
            ));            
		 }
    
}