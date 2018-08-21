<?php
/*
echo $this->BootForm->formGroup(
    "Nazwa skrócona",
    "col-md-9",
    [
        "id" => "CustomerName",
        "placeHolder" => "krótka nazwa klienta"
    ]
);

Poniższe (metod input) daje dokładnie taki sam rezultat, jak zakomentowane powyższe plus dodatkowo Cake generuje:
name="data[Customer][Name]
*/
echo $this->BootForm->input('Name',
    [
        'label' => 'Nazwa skrócona',
        "placeHolder" => "krótka nazwa klienta",
        'div' => ['class' => 'col-md-9']
    ]
);

echo $this->BootForm->formGroup(
    "Nazwa pełna",
    "col-md-12",
    [
        "id" => "AdresSiedzibyName",
        "placeHolder" => "pełna nazwa klienta"
    ]
);

echo $this->BootForm->formGroup(
    "Ulica",
    "col-md-9",
    [
        "id" => "AdresSiedzibyUlica",
        "placeHolder" => "ulica"
    ]
);

echo $this->BootForm->formGroup(
    "Numer",
    "col-md-3",
    [
        "id" => "AdresSiedzibyNrBudynku",
        "placeHolder" => "numer"
    ]
);

echo $this->BootForm->formGroup(
    "Kod",
    "col-md-3",
    [
        "id" => "AdresSiedzibyKod",
        "placeHolder" => "kod pocztowy"
    ]
);

echo $this->BootForm->formGroup(
    "Miasto",
    "col-md-5",
    [
        "id" => "AdresSiedzibyMiasto",
        "placeHolder" => "miasto"
    ]
);

echo $this->BootForm->formGroup(
    "Kraj",
    "col-md-4",
    [
        "id" => "AdresSiedzibyKraj",
        "placeHolder" => "kraj"
    ]
);
