<?php
/*
*   20.12.2022
    Wykorzystujemy ten kontroler zamiast OrdersController
    Tam już duzo kodu jest...
    Wcześniej napisana obsługa specjalnego wyszukiwania dla Ani

    Teraz (20.12.2022) zaczynamy robienie zamówień po nowemu
*/

App::uses('AppController', 'Controller');

class DisposalsController extends AppController {

    public $helpers = array('Ma', 'BootForm', 'Boot');

    public $components = array('Paginator');
    
    public $paginate = null;

    public function nowe() {
        $this->layout='bootstrap';
    }

    /// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    /// It was earilier made

    public function index() {

        // Date picker config
        $config = $this->Disposal->configForSpecialSearching;  
        
        $this->set( compact('config') );        
        $this->layout='bootstrap';
	}   

    /**
     * Wywoływane jest przez javascript przy zmianie parametrów na stronie /szukaj      */
    public function search() {

        // Ustawiamy parametry szukania, na podstawie otrzymanych danych
        $this->paginate = $this->Disposal->setTheSearchParams($this->request->data);

        $this->Paginator->settings = $this->paginate;                
        $disposals = $this->Disposal->theSpecialFind();
        $howmuc = 0;//$this->Disposal->theSpecialFindIle(); // ile wszystkich rekordów
        
        $data = $this->Disposal->otrzymane; 
        $this->set( compact( ['data', 'disposals', 'howmuc']) ); 
        
    }

}