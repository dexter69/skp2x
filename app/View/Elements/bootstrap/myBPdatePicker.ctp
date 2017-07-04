<?php

$this->BootForm->placeDatePicker( $config );

?>
<div class="picker-container">
    <div class="input-group date"
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
 $code = 'var gibon = "hau, miau";';
 echo $this->Html->scriptBlock($code,
    array('block' => 'scriptBottom'));


