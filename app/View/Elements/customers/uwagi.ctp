<?php

echo $this->BootForm->formGroup(
    "Uwagi",
    "col-md-7",
    [
        "id" => "CustomerComment",
        "type" => "textarea",
        "rows" => 6,
        "placeHolder" => "uwagi"
    ]
);

echo $this->BootForm->formGroup(
    "Ważne!",
    "col-md-5",
    [
        "id" => "CustomerImportant",
        "type" => "textarea",
        "rows" => 6,
        "placeHolder" => "informacje o których trzeba pamiętać przy zamówieniu - to co tutaj wpiszesz, będzie się pojawiać jako „przypominajka” przy składniu/edycji zamówienia"
    ]
);