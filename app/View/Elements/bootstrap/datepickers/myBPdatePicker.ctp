<?php
/* ########################  Datepicker

    USES bootstrap datepicker
    https://bootstrap-datepicker.readthedocs.io
*/

$klasa1 = "picker-container";
$klasa2 = "input-group";

// potrzebne pliki js i css
echo $this->element('bootstrap/datepickers/subels/head');

//$config = $konfig[0];

if( count($config) > 1 ) { // znaczy 2 powiązane kalendarze
    echo "Yes, yes!<br><br>";
}

echo $this->element(
    'bootstrap/datepickers/subels/core', array(
    'id' => $config[0]['id'],
    'klasa1' => $klasa1,
    'klasa2' => $klasa2,
    'label' => $config[0]['label']
));

$code = $this->element('bootstrap/datepickers/subels/js', array(
        'hereval' => $config[0]['acc'],
        'id' => $config[0]['id'],        
        'klasa' => $klasa2
));
// stripScript - bo kod zawiera <scritpt> tag, niepotrzebny - bez tego syntax err
echo $this->Html->scriptBlock($this->App->stripScript($code), array('block' => 'scriptBottom'));

echo '<br><br>';
echo count($config);
echo '<br><br>';
echo '<pre>'; print_r($config); echo '</pre>';




