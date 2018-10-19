<?php
App::uses('AppController', 'Controller');
/*

*/

class WebixPrivateOrdersController extends AppController {

     public function getTheOrders( $idOpiekuna = 0 ) {

        $ret = $this->WebixPrivateOrder->getTheOrders( $idOpiekuna );

        $this->set(compact(['ret']));
        $this->set('_serialize', 'ret');
    }

}