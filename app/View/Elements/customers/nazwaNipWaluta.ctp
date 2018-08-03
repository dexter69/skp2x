<?php

echo $this->BootForm->formGroup(
    "Nazwa skrócona",
    "col-md-7",
    [
        "id" => "CustomerName",
        "placeHolder" => "krótka nazwa klienta"
    ]
);

echo $this->BootForm->formGroup(
    "NIP",
    "col-md-3",
    [
        "id" => "CustomerVatnoTxt",
        "placeHolder" => "nip"
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
