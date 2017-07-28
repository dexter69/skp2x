<?php

App::uses('AppController', 'Controller');

class DisposalsController extends AppController {

    public function test() {

        //$data = ['kwa' => 'muu'];
        $data = $this->Disposal->find(
            'all', [
             'fields' => ['Disposal.id', 'Disposal.nr', 'Disposal.data_publikacji'],
             'limit' => 3
        ]);
        $this->layout='ajax';
        $this->set( compact( 'data') ); 
    }

}