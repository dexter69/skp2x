<?php
$this->set('title_for_layout', 'Etykiety');
$this->layout='bootstrap';
//echo "$test";

echo $this->Form->create(array('class' => 'row'));

echo $this->BootForm->input('numer', array('label' => 'Numer zlecenia PRODUKCYJNEGO')
        );

echo $this->BootForm->end(array(
    'label' => 'Pokaż',
    'div' => array('class' => 'col-xs-12')
));

if( $req != null ) {
    $this->App->print_r2($req);
}