<?php

App::uses('AppController', 'Controller');

/**
 * CakePHP TasksController
 * @author dexter
 */
class TasksController extends AppController {
    
    public $helpers = array('BootForm');
    
    /* To będzie metoda wyświetlająca interfejs do etykiet dla przebieralni */
    public function label() {
        
        $req = null; $result = null;
        if ($this->request->is(array('post', 'put'))) {
            $req = $this->request->data;            
            $this->Task->taskViaNoExists($req['Task']['numer']);
            $result = $this->Task->taskViaErr;
            /*  Tymczasowa modyfikacja - chcemy mieć w kartach opcję etykiety 'lo'.
                Taka symulacja. Później do usunięcia */
            $result = $this->tmpOpp($result);
        }
        $box = $this->batons['rodzaje'];
        $this->set( compact('result', 'box') );
    }
    
    //tymczasowa funkcja, formatujemy dane
    
    private function tmpOpp( $rqdata ) {
        
        if( isset($rqdata['data']['Ticket']) ) { //Mamy jakieś dane kartowe
            $i=0;
            foreach( $rqdata['data']['Ticket'] as $karta ) {
               // oblicz nakład
               $rqdata['data']['Ticket'][$i]['naklad'] = $karta['ilosc']*$karta['mnoznik'];
               unset($rqdata['data']['Ticket'][$i]['ilosc'], $rqdata['data']['Ticket'][$i]['mnoznik']);
               // dane do wyświetlania kontrolki (która wartość jest aktywna)i zawartości pola input
               $rqdata['data']['Ticket'][$i]['kontrol'] = $this->batonSize($rqdata['data']['Ticket'][$i]['naklad']);
               //Linia niżej już nie potrzebna
               //$rqdata['data']['Ticket'][$i]['lo'] = ( $i % 2 == 0 ) ? 'en' : 'pl'; 
               //Troche prymitywnie (bo nam sie nie chce) pobierz nr handlowego dla danej karty
               $rqdata['data']['Ticket'][$i]['hnr'] = $this->Task->Ticket->getNrHandlowgo($rqdata['data']['Ticket'][$i]['id']);
               $i++;
            }
        }
        return $rqdata;
    }
    
    // ################## TEST / DEPREC <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    // wylicz dane, który przycisk ma być aktywny i czy coś ma być w polu input
    private function batonSize( $naklad ) {
        
        if( $naklad >= $this->batons['max'] ) { // nakład większy od poj. największego batona
            return array(
                'active' => $this->batons['indmax'], // indeks maks ilości
                'input' => $this->batons['rodzaje'][$this->batons['indmax']]
            );
        }
        foreach( $this->batons['rodzaje'] as $key => $val ) {
            if( $naklad == $val ) { // nakład równy pojemności któregoś z batonów
                return array(
                    'active' => $key, // indeks batona w który się miesci nakład
                    'input' => $this->batons['rodzaje'][$key]
                );
            }
        }
        /* I w końcu trzeci przypadek: nakład jest mniejszy od największego batona
         * i nie jest równy żadnemu z mniejszych batonów */
        return array(
            'active' => null, // żaden "klikacz" nie jest aktywny
            'input' => $naklad // w input wpisujemy nakład
        );
    }
    
    //testowa metoda
    public function index() {
        
        $active = $this->Task->getActive();
        $this->set( compact('active' ) );
    }   
    
    
    // Chcemy metode, która będzie po numerze wyświetlać zlecenie
    public function no( $no = null, $year = null ) {
        
        $nr = $no; $rok = $year;
        if( $this->nrPramsAreCorrect($nr, $rok) ) {
            $msg = null;
        } else {
            $msg = $this->nrPrams['msg'];
        }
        $this->set( compact('nr', 'rok', 'msg' ) );
    }
    
    // sprawdza, czy parametry mieszczą się w założonych granicach
    private function nrPramsAreCorrect($no, $year = null) {
        
        /* 1. $no musi być liczbą (skłądać się tylko z cyfr) oraz mieć wartość
              z przedziału 1 - 99999 - w org. bazy takie założyłem max */
        if( !is_numeric($no) ) { //&& $no > 0 && $no < 100000 ) {
            $this->setErr("Numer zlecenia nie jest liczbą.");            
            return false;
        }
        if( (int)$no < 1 || (int)$no > 99999 ) {
            $this->setErr("Numer zlecenia poza zakresem (1 - 99999)");            
            return false;
        }
        /* 2. $year musi być null lub musi być liczbą z zakresu 14 - bieżący rok */
        if( $year != null ) {
            if( !is_numeric($year) ) {
                $this->setErr("Rok w numerze zlecenia nie jest liczbą.");            
                return false;
            }
            $now = (int)date("y");
            if( (int)$year < 14 || (int)$year >  $now ) {
                $this->setErr("Rok w numerze zlecenia poza zakresem (14 - $now)");            
                return false;
            }
        }
        return true;
    }
    
    // tu zapisujemy błędy przy sprawdzaniu parametrów
    private $nrPrams = array(
        'error' => false,
        'msg' => null
    );
    
    // ustawia zmienną $noPrams
    private function setErr( $msg = null ) {
        
        $this->nrPrams['error'] = true;
        $this->nrPrams['msg'] = $msg;
    }

}
