<?php
    // Wygląd podglądu proof'a w zależności od parametrów            
    $par = $this->Proof->parametry( $lang, $locked, $editable);
    $this->Proof->setupJsCode($proof, $card);
    
?>
<div id="proof-preview" class="proof-stuff" <?php echo $par['div']; ?>>
    <div id="panel"><p></p><i class="<?php echo $par['iclass'];?>"></i></div>
    <?php
        echo $this->Proof->topTable( $comm ); 
    ?>        
    
</div>
<?php
$this->Proof->printR($proof);
echo "\nlang = $lang";