<?php 

// Chcemy mieć nr job'a do do linku do etykiet w widoku karty
if( $card['Job']['nr'] ) { // jeżeki mamy jakis nr job'a
    $this->set("jnr", (int)substr($card['Job']['nr'],2));
} else {
    $this->set("jnr", 0);
}

echo $this->element('cards/view/head', array(
    'title' => $card['Card']['name'],
    'card_id' => $card['Card']['id']    )); ?>

<div id="kartview" class="cards view">
    <?php
        echo $this->element('cards/view/h2', array('card' => $card['Card'], 'links' => $links )); 
        $comm = $this->Proof->wspolne($card);
    // Ten element dl ?>
    <div id="tabsy">
        <!--
        <ul>
            <li><a href="#karta-tab">Karta</a></li>
            <li><a href="#proof-tab">Proof</a></li>
        </ul>
        -->
        <div id="karta-tab">
        <?php
        echo $this->element('cards/view/dl', array(
            'card' => $card['Card'],
            'order' => $card['Order'],
            'customer' => $card['Customer'],
            'owner' => $card['Owner'],
            'creator' => $card['Creator'],
            'job' => $card['Job'],
            'comm' => $comm,
            'etykieta' => $vju['etykieta']['options'],
            'etylang' => $vju['etylang']['view'],
            'limited' => $limited
        )); 

        // CMYK
        echo $this->element('cards/view/cmyk', array(
            'card' => $card['Card'],
            'vju' => $vju
        ));             
        // Reszta
        echo $this->element('cards/view/rest', array(
            'card' => $card['Card'],
            'vju' => $vju
        ));  
        // Pliki
        if( !empty($card['Upload']) ) {
            echo $this->element('cards/view/pliki', array('limited' => $limited, 'uploads' => $card['Upload'])); 
        } 
        $this->Ma->kontrolka($card, $evcontrol);?>
        </div>
        <div id="proof-tab"><?php
            if( OLD_PDF_PROOF ) {
                echo $this->element('cards/view/proof-tab', array(
                    'card' => $card['Card'],
                    'vju' => $vju,
                    'comm' => $comm,
                    'proof' => $card['Proof'],
                    'lang' => $card['Customer']['proof-lang'],
                    'waluta' => $card['Customer']['waluta'],
                    'locked' => true, // to zawsze niech bedzie przy defaultowym ładowaniu
                    'editable' => false /*zawsze na wszelki wypadek, a po sprawdzeniu ajaxem
                     zmieniamy to ewentualnie*/
                ));      
            }
        ?>    
        </div>
    </div>
</div>
<!-- Do zmieniania daty perso -->
<div id="datepicker"></div><div id="komunikat"></div>

<?php 
//$this->Proof->printR($vju);
//echo $this->App->print_r2($card);
//$this->Ma->kontrolka($card, $evcontrol);
//echo $this->App->print_r2($evcontrol);






