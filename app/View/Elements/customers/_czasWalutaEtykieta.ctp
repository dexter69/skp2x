<!--
<div class="row">
-->
<?php
//col-md-offset-5
echo $this->BootForm->formGroup(
    "Czas realizacji",
    "col-md-4",
    [
        "id" => "CustomerCr",
        "type" => "number",
        "min"  => 1,
        "value" => 12
    ]
);

echo $this->BootForm->formGroup(
    "Waluta",
    "col-md-4",
    [
        "id" => "CustomerWaluta",
        "type" => "select",
        "selectOptions" => ["PLN"=>"PLN", "EUR"=>"EUR", "USD"=>"USD"]        
    ]
);

echo $this->BootForm->formGroup(
    "Język etykiety",
    "col-md-4",
    [
        "id" => "CustomerEtylang",
        "type" => "select",
        "selectOptions" => ["Polski"=>"pl", "Angielski"=>"en", "Niemiecki"=>"de"] 
    ]
);
?>
<!--
</div>
-->