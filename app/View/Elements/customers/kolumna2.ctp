<?php

echo $this->BootForm->formGroup(
    "Czas realizacji",
    NULL,
    [
        "id" => "CustomerCr",
        "type" => "number",
        "min"  => 1,
        "value" => 12
    ]
);

echo $this->BootForm->formGroup(
    "Waluta",
    NULL,
    [
        "id" => "CustomerWaluta",
        "type" => "select",
        "selectOptions" => ["PLN"=>"PLN", "EUR"=>"EUR", "USD"=>"USD"]        
    ]
);

echo $this->BootForm->formGroup(
    "Język etykiety",
    NULL,
    [
        "id" => "CustomerEtylang",
        "type" => "select",
        "selectOptions" => ["Polski"=>"pl", "Angielski"=>"en", "Niemiecki"=>"de"] 
    ]
);