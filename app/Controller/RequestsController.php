<?php

App::uses('AppController', 'Controller');

class RequestsController extends AppController {

    public $helpers = array('Ma', 'BootForm', 'Boot');

    // Szukaj wg zadanych parametrów
    public function searchx() {

        $abc = $this->testy( $this->request->data );
        $result = $this->Request->theSpecialSerach($this->request->data);
        $answer =  $result;
        $data = $abc['dane'];
        $this->set( compact('answer', 'data') ); 
        $this->layout='ajax'; // nie wysyłamy całej struktury strony tylko fragment html
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

    public function index() {

        // Date picker config
        $config = $this->Request->configForSpecialSearching;  
        
        $this->set( compact('config') );        
        $this->layout='bootstrap';
	}

    

}