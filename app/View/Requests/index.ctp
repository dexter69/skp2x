<?php 
    $this->Html->scriptBlock($jscode, array('inline' => false)); 
    echo $this->Html->script(
        array(
            '../bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.min',
            '../bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker_pl.min',            
            'request/index.js?v=' . time()
        ),
        array('block' => 'scriptBottom')
    );
    $this->set('title_for_layout', 'Szukaj');    
?>

<div class="row filter-panel">
    <div class="col-md-12">
        <?php            
            echo $this->element('bootstrap/myBPdatePicker', array(
                'config' => $config
            ));
            echo '<br><br>';
        ?>
        
        <?php
           // echo '<pre>'; print_r($config); echo '</pre>';
        ?>
        
    </div>    
</div>




