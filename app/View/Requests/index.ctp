<?php 
    $jscode = "var " . $config['varname'] . "= " . json_encode($config['theobj']) . ";";
    $this->Html->scriptBlock($jscode, array('inline' => false));     

    $this->set('title_for_layout', 'Szukaj');    
    echo $this->Html->css('boot/ko-search.css?v=' . time(), null, array('inline' => false));
    echo $this->Html->script('ko-search/search.js?v=' . time(), array('block' => 'scriptBottom'));
?>

<div class="row filter-panel">   
    <div class="col-md-4">
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
    <div class="col-md-1">
        <table  class="table">  
            <tr>
                <td class="text-primary ikony">
                    <span id="loopka" class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    <span id="loading" class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                </td>
            </tr>  
        </table>        
    </div>
</div>
<div id="rezultat" class="row">    
    <div id="tmp" class="col-md-12"></div>
    <div id="czas" class="col-md-12"></div>
</div>

<?php
//$this->App->print_r2($config);