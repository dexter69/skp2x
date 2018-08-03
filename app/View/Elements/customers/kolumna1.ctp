<div class="row"> 
<?php

echo $this->BootForm->formGroup(
    "Nazwa skrócona",
    "col-md-8",
    [
        "id" => "CustomerName",
        "placeHolder" => "krótka nazwa klienta"
    ]
);

echo $this->BootForm->formGroup(
    "NIP",
    "col-md-4",
    [
        "id" => "CustomerVatnoTxt",
        "placeHolder" => "nip"
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

?>
</div>