<?php 
echo $this->element('cards/view/head', array('title' => $card['Card']['name'])); ?>

<div id="kartview" class="cards view">
    <?php echo $this->element('cards/view/h2', array('card' => $card['Card'], 'links' => $links )); 

    echo $this->element('cards/view/dl', array(
        'card' => $card['Card'],
        'order' => $card['Order'],
        'customer' => $card['Customer'],
        'owner' => $card['Owner'],
        'creator' => $card['Creator'],
        'job' => $card['Job']
    )); 


    echo $this->element('cards/view/cmyk', array(
        'card' => $card['Card'],
        'vju' => $vju
    ));             

    echo $this->element('cards/view/rest', array(
        'card' => $card['Card'],
        'vju' => $vju
    ));  

    if( !empty($card['Upload']) ) {
        echo $this->element('cards/view/pliki', array('uploads' => $card['Upload'])); 
    } ?>

</div>
<!-- Do zmieniania daty perso -->
<div id="datepicker"></div><div id="komunikat"></div>

<?php $this->Ma->kontrolka($card, $evcontrol);		




