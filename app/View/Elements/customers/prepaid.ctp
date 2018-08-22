<?php

$vju['forma_zaliczki']['div'] = ['class' => 'col-md-3']; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('forma_zaliczki', $vju['forma_zaliczki']);

echo $this->BootForm->formGroup(
    "%",
    "col-md-2",
    [
        "id" => "CustomerProcentZaliczki",
        "type" => "number",
        "min"  => 1,
        "max"  => 100,
        "value" => 100
    ]
);