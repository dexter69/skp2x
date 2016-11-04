<?php

/* To ma być nowy model operujący na tablicy jobs dla celów obsługi druku etykiet.
 * Po prostu chcemy czysty kod */

App::uses('AppModel', 'Model');

/**
 * CakePHP Task
 * @author dexter
 */
class Task extends AppModel {
    
    public $useTable = 'jobs';
    
    public $hasMany = array(
        'Ticket' => array(
            'fields' => array(
                'Ticket.id', 'Ticket.name', 'Ticket.ilosc',
                'Ticket.mnoznik', 'Ticket.etylang', 'Ticket.isperso'
            )
        )
    );
    
    /* chcemy sprawdzić czy istnieje produkcyjne z podanym numerem
     * Numer jest w formie kilku cyfr (tylko i wyłącznie), bez roku. Zakładamy, że chodzi o rok bieżący.
     * Jeżeli zlecenie z takim numerem nie istnieje w bieżącym roku to szukamy w roku
     * poprzednim.
     */
    public $taskViaErr = array(
        'err' => false, // prawda, jeżeli wystąpił błąd
        'msg' => null, // informacja o błędzie        
        'data' => null // jeżeli coś znaleziono, to tu będzie ten rekord
    );
    
    public function taskViaNoExists( $nr_string ) {
        
        if( !ctype_digit($nr_string) ) { // nie składa się wyłącznie z cyfr
            $this->taskViaErr['err'] = true;
            $this->taskViaErr['msg'] = 'To nie jest prawidłowy numer!';
            return false;
        }
        // czy numer w sensownym zakresie
        $nr = (int)$nr_string;
        if( $nr < 1 || $nr > MAX_BASE) {
            $this->taskViaErr['err'] = true;
            $this->taskViaErr['msg'] = 'Numer poza zakresem!';
            return false;
        }
        if( !$this->anyTaskExists($nr) ) {
            $this->taskViaErr['err'] = true;
            $t = (int)date("y");
            $this->taskViaErr['msg'] = 
                    'Zlecenia o numerach: <b>' . $nr . "/" . $t . '</b> i <b>' . $nr . "/" . ($t-1) . "</b> nie istnieją!";
            return false;
        }
        return true;
    }
    
    // sprawdzamy, czy zamówienie o numerze $nr (bez roku, np. 123) istnieje
    // jeżeli nie to sprawdzamy jeszcze czy zamówienie z poprzedniego roku o tym samym nrze istnieje
    private function anyTaskExists( $nr ) {
    
        $dbnr = $this->digitOnlyNr2dbNr( $nr );
        $opcje = array('conditions' => array('nr' => $dbnr));
        $record = $this->find('first', $opcje);
        if( empty($record) ) {
            // spróbuj rok wcześniej
            $dbnr = $this->digitOnlyNr2dbNr( $nr, -1 );
            $opcje = array('conditions' => array('nr' => $dbnr));
            $record = $this->find('first', $opcje);
            if( empty($record) ) {
                return false;
            }
        }
        $this->taskViaErr['data'] = $record;
        return true;
    }
    
    // chcemy joby, które są aktywne (w produkcji)
    public function getActive() {
        $conditions = array(
            'status !=' => KONEC            
        );
        $fields = array('id', 'nr');
        return $this->find('all', compact(
                'conditions'
                , 'fields'
        ));
    }
    
    /*  Sprwdza, czy zlecenie $no/$year istnieje, jeżeli tak, to zwraca jego $id.
     *  W przeciwnym wypadku 0. Jeżeli argument $year nie jest podany, to zakłada, że szukasz
     *  z bieżącego roku. */
    public function nr2id($nr = null, $year = null) {
        
        if( $nr ) {
            //$rok = $year != null ? 
        }
        return 0;
    }
    
}
