<?php

echo $this->BootForm->input('osoba_kontaktowa', [
    'label' => 'Osoba kontaktowa',
    'placeHolder' => 'osoba kontaktowa',
    'div' => ['class' => 'col-md-12']
]);

echo $this->BootForm->input('tel', [
    'label' => 'Telefon',
    'placeHolder' => 'telefon',
    'div' => ['class' => 'col-md-12']
]);

echo $this->BootForm->input('email', [
    'label' => 'E-mail',
    'placeHolder' => 'e-mail',
    'div' => ['class' => 'col-md-12']
]);