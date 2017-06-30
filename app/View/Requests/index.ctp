<?php 
    $this->Html->scriptBlock($jscode, array('inline' => false)); 
    $this->set('title_for_layout', 'Szukaj');    
?>

<div class="row filter-panel">
    <div class="col-md-12">
        <?php
            echo $this->element('bootstrap/myDatePicker', array(
                'config' => $config
            ));
            echo '<br><br>';
        ?>
        
        <?php
           // echo '<pre>'; print_r($config); echo '</pre>';
        ?>
        
    </div>    
</div>




