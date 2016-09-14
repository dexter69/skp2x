<?php

echo $this->Form->create(array('class' => 'row'));

echo $this->BootForm->input('numer', array(
    'label' => 'Numer zlecenia PRODUKCYJNEGO',
    'div' => array('class' => 'col-sm-3'),
    'pattern' => "[0-9]{1,5}",
    'title' => 'podaj numer bez roku',
    'placeholder' => 'numer bez roku',
    'maxlength' => '5',
    'required' => true
));

if( $msg ) { // mamy jakieś info o błędach
    $class = 'bg-danger';
} else {
    $class = null;
}
?>

<!-- ewentualne info o błędach -->
<div id="errinfo" class="col-sm-4"><p class="<?php echo $class ?>"><?php echo $msg ?></p></div>

<?php
echo $this->BootForm->end(array(
    'label' => 'Pokaż',
    'div' => array('class' => 'col-sm-12')
));
