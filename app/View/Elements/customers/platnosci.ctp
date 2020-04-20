<?php
$lewy = 7;

$vju['forma_zaliczki']['div'] = ['class' => 'col-md-' . $lewy]; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('forma_zaliczki', $vju['forma_zaliczki']);

$vju['procent_zaliczki']['div'] = ['class' => 'col-md-' . (12-$lewy)]; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('procent_zaliczki', $vju['procent_zaliczki']);

$vju['forma_platnosci']['div'] = ['class' => 'col-md-' . $lewy]; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('forma_platnosci', $vju['forma_platnosci']);

$vju['termin_platnosci']['div'] = ['class' => 'col-md-' . (12-$lewy)]; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('termin_platnosci', $vju['termin_platnosci']);