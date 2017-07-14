<?php 
    //
    $jscode = "var " . $config['varname'] . "= " . json_encode($config['theobj']) . ";";

    $this->Html->scriptBlock($jscode, array('inline' => false));     
    $this->set('title_for_layout', 'Szukaj');    
?>

<div class="row filter-panel">        
    <?php
    //Pasek magnetyczny 
    echo $this->element('bootstrap/selwrap', array(
        'konfig' => $config['mag'], 
        'klasa'  => 'col-md-2'
    ));   
    //Pasek PVC 
    echo $this->element('bootstrap/selwrap', array(
        'konfig' => $config['pvc'], 
        'klasa'  => 'col-md-2'
    ));
    //KSZTAŁT
    echo $this->element('bootstrap/selwrap', array(
        'konfig' => $config['sha'], 
        'klasa'  => 'col-md-2'
    ));
    //CHIP
    echo $this->element('bootstrap/selwrap', array(
        'konfig' => $config['chip'], 
        'klasa'  => 'col-md-1'
    ));
    ?>
</div>
<div class="row filter-panel"> 
    <div class="col-md-6">
    <?php
        echo $this->element('bootstrap/datepickers/myBPdatePicker', array(
            'config' => [$config['od'], $config['do']]
            //'config' => [$config['od']]
        ));
    ?>    
    </div>
</div>
<?php
//$this->App->print_r2($config);