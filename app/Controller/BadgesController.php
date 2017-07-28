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
        //$this->layout='ajax'; // nie wysyłamy całej struktury strony tylko fragment html
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
}