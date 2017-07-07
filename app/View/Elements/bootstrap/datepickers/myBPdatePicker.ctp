<?php
/* ########################  Datepicker

    USES bootstrap datepicker
    https://bootstrap-datepicker.readthedocs.io
*/

$klasa1 = "picker-container";
$klasa2 = "input-group";

// potrzebne pliki js i css
echo $this->element('bootstrap/datepickers/subels/head');

echo $this->element(
    'bootstrap/datepickers/subels/core', array(    
    'config' => $config,
    'klasa1' => $klasa1,
    'klasa2' => $klasa2
));

$code = $this->element('bootstrap/datepickers/subels/js', array(
    'config' => $config[0],    
    'klasy' => ".$klasa1 .$klasa2" 
));
// stripScript - bo kod zawiera <scritpt> tag, niepotrzebny - bez tego syntax err
echo $this->Html->scriptBlock($this->App->stripScript($code), array('block' => 'scriptBottom'));

if( count($config) > 1 ) { // znaczy 2 powiązane kalendarze
    // Więc js dla drugiego pickera
    $code = $this->element('bootstrap/datepickers/subels/js', array(
        'config' => $config[1],    
        'klasy' => ".$klasa1 .$klasa2" 
    ));
    // stripScript - bo kod zawiera <scritpt> tag, niepotrzebny - bez tego syntax err
    echo $this->Html->scriptBlock($this->App->stripScript($code), array('block' => 'scriptBottom'));
}

echo '<br><br>';
echo '<pre>'; print_r($config); echo '</pre>';




