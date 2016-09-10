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
            'fields' => array('Ticket.id', 'Ticket.name')
        )
    );
    
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
