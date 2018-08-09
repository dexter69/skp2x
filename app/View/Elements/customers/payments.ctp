<!--
<div class="form-group col-md-9">
    <label for="CustomerFormaZaliczki">Forma przedpłaty</label>
    <select id="CustomerFormaZaliczki" class="form-control">
        <option value="volvo">Volvo</option>
        <option value="saab">Saab</option>
        <option value="vw">VW</option>
        <option value="audi" selected="selected">Audi</option>
    </select>
</div>
-->
<?php

echo $this->BootForm->formGroup(
    "Forma przedpłaty",
    "col-md-8",
    [
        "id" => "CustomerFormaZaliczki",
        "type" => "select",
        "selectOptions" => ["BEZ PRZEDPŁATY"=>0, "PRZELEW"=>2, "GOTÓWKA"=>3, "INNA (UWAGI)"=>99],
        "default" => 1 // nr opcji w tablicy "selectOptions", czyli tu druga (0, 1, 2)
    ]
);

echo $this->BootForm->formGroup(
    "%",
    "col-md-4",
    [
        "id" => "CustomerProcentZaliczki",
        "type" => "number",
        "min"  => 1,
        "max"  => 100,
        "value" => 100
    ]
);

echo $this->BootForm->formGroup(
    "Płatność po",
    "col-md-8",
    [
        "id" => "CustomerFormaPlatnosci",
        "type" => "select",
        "selectOptions" => ["BRAK"=>0, "PRZELEW"=>2, "GOTÓWKA"=>3, "POBRANIE" => 4, "INNA (UWAGI)"=>99]        
    ]
);

echo $this->BootForm->formGroup(
    "Termin",
    "col-md-4",
    [
        "id" => "CustomerTerminPlatnosci",
        "type" => "number",
        "min"  => 1,
        'disabled' => true
    ]
);

// CustomerProcentZaliczki
