<!--
<div class="row">
-->
<?php
echo $this->BootForm->formGroup(
    "Płatność po",
    "col-md-3 col-md-offset-1",
    [
        "id" => "CustomerFormaPlatnosci",
        "type" => "select",
        "selectOptions" => ["BRAK"=>0, "PRZELEW"=>2, "GOTÓWKA"=>3, "POBRANIE" => 4, "INNA (UWAGI)"=>99]        
    ]
);

echo $this->BootForm->formGroup(
    "Termin",
    "col-md-2",
    [
        "id" => "CustomerTerminPlatnosci",
        "type" => "number",
        "min"  => 1,
        'disabled' => true
    ]
);
?>
<!--
</div>
-->