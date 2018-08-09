<div class="row">
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
?>
</div>