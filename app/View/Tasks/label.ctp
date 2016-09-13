<?php
$this->set('title_for_layout', 'Etykiety');
$this->layout='bootstrap';

// formularz do znajdowania
echo $this->element('tasks/label/getTaskForm');
if( $result != null ) { // znaczy było POST
    if( !empty($result['data']) ) { // mamy coś
        $this->App->print_r2($result['data']); // prezentuj
    } else { // wyświetl info o błędach
        echo $result['msg'];
    }
}
