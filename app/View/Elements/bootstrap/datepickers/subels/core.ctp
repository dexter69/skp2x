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
    <div class="<?php echo $klasy; ?>"
        data-provide="datepicker"
        data-date-language="pl"
        data-date-autoclose="true"
        data-date-clear-btn="true"
        data-date-start-date="01.09.2014"> <!-- Faktycznie w październiku 2014 zaczeło się coś dziać -->
            <?php echo $inputs; ?>        
    </div>
</div>