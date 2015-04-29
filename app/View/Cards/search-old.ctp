<div id="search_wrap">
<?php
echo $this->Html->css('card', null, array('inline' => false));
$this->Ma->displayActions();
//echo $ile . '<br/><br/>';
//echo $fraza . '<br/><br/>';
//echo '<pre>';	print_r($wynik); echo  '</pre>';
//echo '<pre>';	print_r($wynik['karty'][0]); echo  '</pre>';
?>
<h2><?php 
        if( $ile ) { echo 'Wyniki dla szukanej frazy <span>' . $fraza . '</span>'; }
        else { echo 'Nie ma żadnych wyników dla szukanej frazy <span>' . $fraza. '</span>'; }        
    ?>
</h2>

<?php

if( $ile ) {
    if( array_key_exists('zamowienie', $wynik) ) {//&& !empty($wynik['zamowienie']))
    // zamówienia zlecenia
        $list = array();
        if( !empty($wynik['zamowienie']) ) {
           $list[] =   'Zamówienie&nbsp;&nbsp;' .
            $this->Html->link(
                $this->Ma->bnr2nrh($wynik['zamowienie']['Order']['nr'], $wynik['zamowienie']['User']['inic']),
                array('controller' => 'orders', 'action' => 'view', $wynik['zamowienie']['Order']['id']), 
                array('escape' => false)
            );                   
        }
        if( !empty($wynik['zlecenie']) ) {
           $list[] =   'Zlecenie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . 
             $this->Html->link(
                $this->Ma->bnr2nrj($wynik['zlecenie']['Job']['nr']),
                array('controller' => 'jobs', 'action' => 'view', $wynik['zlecenie']['Job']['id']), 
                array('escape' => false)
            );
        }
        echo $this->Html->nestedList( $list, array('class' => 'zamzle'), null, 'ol');
    } else { //klienci i karty
        
        if( !empty($wynik['klienci']) ) { 
            $list = array();
            foreach($wynik['klienci'] as $value) {
               $list[] =  $this->Html->link(
                    $value['Customer']['name'],
                    array('controller' => 'customers', 'action' => 'view', $value['Customer']['id']), 
                    array('escape' => false)
                );
            }
            echo '<h3>Klienci:</h3>';
            echo $this->Html->nestedList( $list, array('class' => 'klikar'), null, 'ol');
        }
        if( !empty($wynik['karty']) ) { 
            $list = array();
            foreach($wynik['karty'] as $value) {
               $list[] =  $this->Html->link(
                    $value['Card']['name'],
                    array('controller' => 'cards', 'action' => 'view', $value['Card']['id']), 
                    array('escape' => false)
                );
            } 
            echo '<h3>Karty:</h3>';
            echo $this->Html->nestedList( $list, array('class' => 'klikar'), null, 'ol');
        }
    }
}
//echo '<pre>';	print_r($wynik); echo  '</pre>';
?>
</div>