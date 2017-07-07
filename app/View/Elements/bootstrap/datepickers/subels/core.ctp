<?php
    $inputs = $this->element(
        'bootstrap/datepickers/subels/input', array(    
        'label' => $config[0]['label'],
        'id' => $config[0]['id']
    )); 
    $klasy = $klasa2 . " date";
    if( count($config) > 1 ) { // znaczy 2 powiązane kalendarze
        $inputs .= $this->element(
            'bootstrap/datepickers/subels/input', array(    
            'label' => $config[1]['label'],  
            'id' => $config[1]['id']              
        ));
        $klasy .= " input-daterange";        
    }
    
?>

<div  class="<?php echo $klasa1; ?>">
    <div class="<?php echo $klasy; ?>" data-provide="datepicker" data-date-language="pl" data-date-autoclose="true" data-date-clear-btn="true">
        <?php echo $inputs; ?>        
    </div>
</div>