<?php
    // Wygląd podglądu proof'a w zależności od parametrów            
    $par = $this->Proof->parametry( $lang, $locked, $editable);
    $this->Proof->setupJsCode($proof, $card);
    
?>
<div id="proof-preview" <?php echo $par['class']; ?>>
    <div id="panel">
        <p></p>
        <i class="fa fa-lock"></i>
        <i class="fa fa-unlock"></i>
        <i class="fa fa-spinner fa-pulse"></i>
    </div>
    <?php
        echo $this->Proof->topTable( $comm ); 
    ?>        
    
</div>
<?php
$this->Proof->printR($proof);
echo "\nlang = $lang";