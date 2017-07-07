<?php 
    $jscode =  "var " . $config['objname'] . " = " . json_encode($config) . ";";
    $this->Html->scriptBlock("\n" . $jscode, array('inline' => false));     
    $this->set('title_for_layout', 'Szukaj');    
?>

<div class="row filter-panel">
    <div class="col-md-3">
        <?php
            echo $this->element('bootstrap/datepickers/myBPdatePicker', array(
                'config' => [$config['od'], $config['do']]
            ));
        ?>
    </div>    
</div>
<?php
    echo '<br><br>';
    echo '<pre>'; print_r($config); echo '</pre>';
    
?>




