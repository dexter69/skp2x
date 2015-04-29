<?php
echo $this->Html->css('search', null, array('inline' => false));
$this->set('title_for_layout', 'Wyniki...');
$this->Ma->displayActions();
//echo "search2!\n\n";
//echo '<pre>';	print_r($wynik['karty'][0]); echo  '</pre>';
//echo '<pre>';	print_r($wynik['klienci'][0]); echo  '</pre>';
//echo '<pre>';	print_r($wynik); echo  '</pre>';

echo '<h2 class="sirczh2">';
if( $ile ) { 
    echo 'Wyniki dla szukanej frazy <span>' . $fraza . '</span>';     
}
else { 
    echo 'Nie ma żadnych wyników dla szukanej frazy <span>' . $fraza. '</span>';
}
echo '</h2>';

foreach($wynik as $key => $item) {
    switch($key) {
       case 'karty': $nag = 'Karty:'; break;
       case 'klienci': $nag = 'Klienci:'; break;
       case 'zamowienie': $nag = 'Zamówienie:'; break;
       case 'zlecenie': $nag = 'Zlecenie:'; break;
       default:  $nag = $key;   
    }
    if( !empty($item) ) {
        echo '<div class="sircz-div related">';
            echo '<p class="wyniknag">' . $nag . '</p>';
            echo $this->Ma->makeTableFromSearch($key, $item);
        echo '</div>';
    }
    
}