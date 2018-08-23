<?php

$vju['cr']['div'] = ['class' => 'col-md-4']; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('cr', $vju['cr']);

$vju['waluta']['div'] = ['class' => 'col-md-4']; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('waluta', $vju['waluta']);

$vju['etylang']['div'] = ['class' => 'col-md-4']; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('etylang', $vju['etylang']);