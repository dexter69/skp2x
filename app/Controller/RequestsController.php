<?php

/*
*  Kontroler do zamówień z WEBIX
*/

App::uses('AppController', 'Controller');

class RequestsController extends AppController {       
    
    /*
    * Gdy nie ma podanego $id (zamówienia handlowego), to znaczy, że dodajemy nowe.
    * W przeciwnym wypadku edycja
    */
    public function addedit($id = null) {

        if( $id ) {            
            $edycja = $id;
        } else {            
            $edycja = 0;
        }        
        $this->set( compact( 'edycja') ); 
        $this->layout='webix';
    }

}