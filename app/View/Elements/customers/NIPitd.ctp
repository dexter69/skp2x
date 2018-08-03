<div class="row">
<?php

echo $this->BootForm->formGroup(
    "Język etykiety",
    "col-md-6",
    [
        "id" => "CustomerEtylang",
        "type" => "select",
        "selectOptions" => ["Polski"=>"pl", "Angielski"=>"en", "Niemiecki"=>"de"] 
    ]
);

echo $this->BootForm->formGroup(
    "Czas realizacji",
    "col-md-6",
    [
        "id" => "CustomerCr",
        "type" => "number",
        "min"  => 1,
        "value" => 12
    ]
);
?>




