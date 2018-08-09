<?php

echo $this->BootForm->formGroup(
    "Nazwa skrócona",
    "col-md-6",
    [
        "id" => "CustomerName",
        "placeHolder" => "krótka nazwa klienta"
    ]
);

echo $this->BootForm->formGroup(
    "Osoba kotaktowa",
    "col-md-4 col-md-offset-2",
    [
        "id" => "CustomerOsobaKontaktowa",
        "placeHolder" => "osoba kotaktowa"
    ]
);