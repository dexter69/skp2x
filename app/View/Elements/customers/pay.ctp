<?php

$vju['forma_zaliczki']['div'] = ['class' => 'col-md-3']; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('forma_zaliczki', $vju['forma_zaliczki']);

$vju['procent_zaliczki']['div'] = ['class' => 'col-md-2']; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('procent_zaliczki', $vju['procent_zaliczki']);

$vju['forma_platnosci']['div'] = ['class' => 'col-md-3 col-md-offset-1']; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('forma_platnosci', $vju['forma_platnosci']);

$vju['termin_platnosci']['div'] = ['class' => 'col-md-2']; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('termin_platnosci', $vju['termin_platnosci']);