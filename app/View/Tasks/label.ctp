<?php
$this->set('title_for_layout', 'Etykiety');
$this->layout='bootstrap';

// formularz do znajdowania
echo $this->element('tasks/label/getTaskForm');

if( $req != null ) {
    $this->App->print_r2($req);
}