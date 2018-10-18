<?php
App::uses('AppController', 'Controller');
/*

*/

class WebixPrivateOrderOwnersController extends AppController {

    public function test() {

        $ret = $this->WebixPrivateOrderOwner->find('all');

        $this->set(compact(['ret']));
        $this->set('_serialize', 'ret');
    }
}