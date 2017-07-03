<?php
/*
USES bootstrap datepicker
https://bootstrap-datepicker.readthedocs.io
*/
echo $this->Html->css(
    '../my-bootstrap-date-picker/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker3.min'
);
echo $this->Html->script(
    array(
        '../my-bootstrap-date-picker/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.min',
        '../my-bootstrap-date-picker/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker_pl.min',            
        //'../my-bootstrap-date-picker/picker.js?v=' . time()
    ),
    array('block' => 'scriptBottom')
);
?>
<div class="picker-container">
    <input type="text" class="form-control"
        data-provide="datepicker"
        data-date-language="pl"
        data-date-autoclose="true">    
</div>

