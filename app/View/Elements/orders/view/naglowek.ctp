<?php 

if( $ppl['jest_zaliczka'] ) { // zamówienie z zaliczką
    switch( $ppl['stan_zaliczki'] ) {
        case null: $klasa_ext = 'null red'; break; // brak jakiegokolwiek wpisu
        case 'confirmed': $klasa_ext = 'confirmed ora'; break; // potwierdzona wpłata
        case 'money': $klasa_ext = 'money gre'; break; // są pieniądze na koncie
    }
    if( $ppl['clickable'] ) { $klasa_ext .= ' clickable'; }
} else { // bez zaliczki - z defincji płatność uregulowana
    $klasa_ext = 'null gre'; // zielone
}
?>

<div class="new-type-header">
    <p class="numer-handlowy">
        <label>
            id:
            <span><?php echo $id;?></span>
        </label>
        <span><?php    echo $numer; ?></span>
    </p>
    <p  class="ikony-handlowe">
        
        <span class="edit-span">
        <?php 
            echo $this->Html->link(
                '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 
                array('controller' => 'orders', 'action' => 'edit', $id),
                array('class' => 'edlink',  'escape' =>false)
            ); ?>
        </span>
        <span class="pdf-span">
        <?php
            echo $this->Html->link(
                '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', 
                array('controller' => 'orders', 'action' => 'view', $id, 'ext' => 'pdf'),
                array('class' => 'pdflink',  'escape' =>false)
            );
        ?>
        </span>
        
        <span id="the-dd-2"
              class="pay-span <?php echo $klasa_ext?>" 
              base="<?php echo $this->webroot; /*info o url*/ ?>"  
              order_id="<?php echo $id; /*id zamówienia*/ ?>" >
            <?php if( $ppl['visible'] ) { /*Nie wszystkim wyświetlamay*/ ?>
                <i class="fa fa-spinner fa-pulse"></i>
                <i class="fa fa-usd" aria-hidden="true" dolar="one"></i>
                <i class="fa fa-caret-right" aria-hidden="true" dolar="one"></i>
                <i class="fa fa-usd drugi" aria-hidden="true" dolar="two"></i>
                <i class="fa fa-usd trzeci" aria-hidden="true" dolar="three"></i>
            <?php } ?>
        </span>

        <span id="servo-span" class="" title="Otwórz w trybie serwisu">
            <i class="fa fa-undo"></i>
        </span>
        
    </p>
    <p class="daty-handlowe">
        
        <label>termin:</label>
            <?php echo $termin; ?>
            <span>(złożone: <b><?php echo $zlozone; ?></b>)</span>
            
    </p>
</div>