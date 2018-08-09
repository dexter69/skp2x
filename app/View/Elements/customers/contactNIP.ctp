<?php
echo $this->BootForm->formGroup(
    "NIP",
    "col-md-4",
    [
        "id" => "CustomerVatnoTxt",
        "placeHolder" => "nip"
    ]
);
?>
<div class="col-md-12"></div>
<?php
echo $this->BootForm->formGroup(
    "Osoba kotaktowa",
    "col-md-5",
    [
        "id" => "CustomerOsobaKontaktowa",
        "placeHolder" => "osoba kotaktowa"
    ]
);
echo $this->BootForm->formGroup(
    "Telefon",
    "col-md-3",
    [
        "id" => "CustomerTel",
        "placeHolder" => "telefon"
    ]
);   
echo $this->BootForm->formGroup(
    "E-mail",
    "col-md-4",
    [
        "id" => "CustomerEmail",
        "placeHolder" => "e-mail"
    ]
);