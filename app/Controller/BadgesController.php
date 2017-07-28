<?php

App::uses('AppController', 'Controller');

class BadgesController extends AppController {

    // Szukaj wg zadanych parametrów
    public function search() {

        $abc = $this->testy( $this->request->data );
        $result = $this->Badge->theSpecialSearch();
        $answer =  $result;
        $data = $abc['dane'];
        $this->set( compact('answer', 'data') ); 
        //$this->layout='ajax'; // wygląda na to, że nie koniezne, gdy cake dostahe xhr
        //sleep(1); // w celach testowych
    }

    private function testy( $received = [] ) {

        $received['dexter'] = 'Hau';        
        $txt = $this->isDateSet( $received['od'] ) ? 'Jest data' : 'Nie ma daty';
        return [
            'txt' => $txt,
            'dane' => $received
        ];        
    }

    private function isDateSet( $dateInString ) {

        return !$dateInString ? false : true;
    }

    public function test() {

        $data = $this->Badge->Request->find(
            'all', [
             //'fields' => ['Badge.id', 'Badge.name', 'Order.id'],
             'limit' => 1
        ]);
        $this->layout='ajax';
        $this->set( compact( 'data') ); 
    }
}