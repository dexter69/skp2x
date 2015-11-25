<?php
/*
    Wykorzystujemy metode input do wykreowania potrzebnego kodu html a następnie przygotowujemy go
    dla javascriptu i umieszczamy go w thehtml
    UWAGA! istotna jest dana wejściowa PATT.'.role', gdyż skrypty z upload.js tego szuka
*/

$this->Html->scriptStart( array('block' => 'scriptBottom') ); 
					
$html2 = json_encode(
    $this->Form->input('Upload.'.PATT.'.role',$vju['role']) .
    '</td><td>' . $this->Form->input('Upload.'.PATT.'.roletxt',$vju['roletxt']) 
);

$html1 = json_encode(
    $this->Form->input('Upload.'.PATT.'.checkbox',
    array( 'type' => 'checkbox', 'label' => false, 'div' => false, 'checked' => true))
);    
?>

$( document ).ready(function() {
    ufs( <?php echo $html1 ?>, <?php echo $html2 ?>, <?php echo PATT ?> );
});

<?php $this->Html->scriptEnd(); 