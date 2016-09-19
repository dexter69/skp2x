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
        $box = $this->xbaton;
        $this->set( compact('result', 'box') );
    }
    
    
    // ################## TEST / DEPREC <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    //tymczasowa funkcja, formatujemy dane
    
    private function tmpOpp( $rqdata ) {
        
        if( isset($rqdata['data']['Ticket']) ) { //Mamy jakieś dane kartowe
            $i=0;
            foreach( $rqdata['data']['Ticket'] as $karta ) {
               $rqdata['data']['Ticket'][$i]['naklad'] = $karta['ilosc']*$karta['mnoznik'];
               unset($rqdata['data']['Ticket'][$i]['ilosc']);
               unset($rqdata['data']['Ticket'][$i]['mnoznik']);               
               $rqdata['data']['Ticket'][$i++]['lo'] = ( $i % 2 == 0 ) ? 'en' : 'pl';                       
            }
        }
        return $rqdata;
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
