<?php
//col-md-offset-5
echo $this->BootForm->formGroup(
    "Czas realizacji",
    "col-md-2",
    [
        "id" => "CustomerCr",
        "type" => "number",
        "min"  => 1,
        "value" => 12
    ]
);

echo $this->BootForm->formGroup(
    "Waluta",
    "col-md-2",
    [
        "id" => "CustomerWaluta",
        "type" => "select",
        "selectOptions" => ["PLN"=>"PLN", "EUR"=>"EUR", "USD"=>"USD"]        
    ]
);

echo $this->BootForm->formGroup(
    "Język etykiety",
    "col-md-2",
    [
        "id" => "CustomerEtylang",
        "type" => "select",
        "selectOptions" => ["Polski"=>"pl", "Angielski"=>"en", "Niemiecki"=>"de"] 
    ]
);

echo $this->BootForm->formGroup(
    "Forma przedpłaty",
    "col-md-3",
    [
        "id" => "CustomerFormaZaliczki",
        "type" => "select",
        "selectOptions" => ["BEZ PRZEDPŁATY"=>0, "PRZELEW"=>2, "GOTÓWKA"=>3, "INNA (UWAGI)"=>99],
        "default" => 1 // nr opcji w tablicy "selectOptions", czyli tu druga (0, 1, 2)
    ]
);

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