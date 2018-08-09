<div class="col-md-12"></div>
<?php
echo $this->BootForm->formGroup(
    "NIP",
    "col-md-10 col-md-offset-2",
    [
        "id" => "CustomerVatnoTxt",
        "placeHolder" => "nip"
    ]
);
echo $this->BootForm->formGroup(
    "Osoba kotaktowa",
    "col-md-12",
    [
        "id" => "CustomerOsobaKontaktowa",
        "placeHolder" => "osoba kotaktowa"
    ]
);

echo $this->BootForm->formGroup(
    "Telefon",
    "col-md-12",
    [
        "id" => "CustomerTel",
        "placeHolder" => "telefon"
    ]
);   
echo $this->BootForm->formGroup(
    "E-mail",
    "col-md-12",
    [
        "id" => "CustomerEmail",
        "placeHolder" => "e-mail"
    ]
);

