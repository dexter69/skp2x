<?php
App::uses('AppController', 'Controller');
/*

*/

class WebixPrivateOrdersController extends AppController {

    public function test() {

        $ret = $this->WebixPrivateOrder->find('all');

        $this->set(compact(['ret']));
        $this->set('_serialize', 'ret');
    }
}