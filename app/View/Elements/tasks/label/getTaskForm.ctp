<?php

echo $this->Form->create(array('class' => 'row'));

echo $this->BootForm->input('numer', array(
    'label' => 'Numer zlecenia PRODUKCYJNEGO',
    'div' => array('class' => 'col-xs-3'),
    'pattern' => "[0-9]{1,4}",
    'title' => 'podaj numer bez roku',
    'placeholder' => 'numer bez roku',
    'maxlength' => '4',
    'required' => true
));

echo $this->BootForm->end(array(
    'label' => 'Pokaż',
    'div' => array('class' => 'col-xs-12')
));