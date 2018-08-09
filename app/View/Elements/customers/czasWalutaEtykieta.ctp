
<?php

echo $this->BootForm->formGroup(
    "Czas realizacji",
    "col-md-7 col-md-offset-5",
    [
        "id" => "CustomerCr",
        "type" => "number",
        "min"  => 1,
        "value" => 12
    ]
);

echo $this->BootForm->formGroup(
    "Waluta",
    "col-md-7 col-md-offset-5",
    [
        "id" => "CustomerWaluta",
        "type" => "select",
        "selectOptions" => ["PLN"=>"PLN", "EUR"=>"EUR", "USD"=>"USD"]        
    ]
);

echo $this->BootForm->formGroup(
    "Język etykiety",
    "col-md-7 col-md-offset-5",
    [
        "id" => "CustomerEtylang",
        "type" => "select",
        "selectOptions" => ["Polski"=>"pl", "Angielski"=>"en", "Niemiecki"=>"de"] 
    ]
);

