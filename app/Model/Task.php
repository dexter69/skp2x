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
    
    // chcemy joby, które są aktywne (w produkcji)
    public function getActive() {
        $conditions = array(
            'status !=' => KONEC
        );
        return $this->find('all', compact('conditions'));
    }
    
}
