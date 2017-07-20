<?php 
    //
    $jscode = "var " . $config['varname'] . "= " . json_encode($config['theobj']) . ";";

    $this->Html->scriptBlock($jscode, array('inline' => false));     
    $this->set('title_for_layout', 'Szukaj');    
?>

<div class="row filter-panel">   
    <div class="col-md-5">
        <table  class="table">  
            <tr>
                <!-- date picker -->
                <td><?php echo $this->element('bootstrap/datepickers/myBPdatePicker', array(
                        'config' => [$config['od'], $config['do']]
                        //'config' => [$config['od']]
                    )); ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-7">
        <table  class="table">  
            <tr>
                <!-- Pasek PVC -->
                <td><?php echo $this->element('bootstrap/selects/select', array(
                            'config' => $config['pvc']          
                        )); ?>
                </td>
                <!-- KSZTAŁT -->
                <td><?php echo $this->element('bootstrap/selects/select', array(
                            'config' => $config['sha']          
                        )); ?>
                </td>
                <!-- CHIP -->
                <td><?php echo $this->element('bootstrap/selects/select', array(
                            'config' => $config['chip']          
                        )); ?>
                </td>
                <!-- Pasek magnetyczny -->
                <td><?php echo $this->element('bootstrap/selects/select', array(
                            'config' => $config['mag']          
                        )); ?>
                </td>
            </tr>  
        </table>
    </div>
</div>
<?php
//$this->App->print_r2($config);