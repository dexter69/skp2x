<?php
/* ########################  Datepicker

    USES bootstrap datepicker
    https://bootstrap-datepicker.readthedocs.io
*/

$klasa1 = "picker-container";
$klasa2 = "input-group";

// potrzebne pliki js i css
echo $this->element('bootstrap/datepickers/subels/head');


?>
<div id="<?php echo $config['id']?>" class="<?php echo $klasa1; ?>">
    <div class="<?php echo $klasa2; ?> date"
        data-provide="datepicker"
        data-date-language="pl"
        data-date-autoclose="true">
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
            &nbsp;<?php echo $config['label']; ?>
        </div>
        <input type="text" class="form-control">     
    </div>
</div>
<?php
$code = $this->element('bootstrap/datepickers/subels/js', array(
        'hereval' => $config['acc'],
        'id' => $config['id'],        
        'klasa' => $klasa2
));
// stripScript - bo kod zawiera <scritpt> tag, niepotrzebny - bez tego syntax err
echo $this->Html->scriptBlock($this->App->stripScript($code), array('block' => 'scriptBottom'));




