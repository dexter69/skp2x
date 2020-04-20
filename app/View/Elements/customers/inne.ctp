<?php
$lewek = 4;

$vju['cr']['div'] = ['class' => 'col-md-' . $lewek]; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('cr', $vju['cr']);

$vju['pozyskany']['div'] = ['class' => 'col-md-' . (12-$lewek)]; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('pozyskany', $vju['pozyskany']);

$vju['waluta']['div'] = ['class' => 'col-md-' . $lewek]; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('waluta', $vju['waluta']);

$vju['etylang']['div'] = ['class' => 'col-md-' . (12-$lewek)]; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('etylang', $vju['etylang']);