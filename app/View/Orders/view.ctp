<?php
//echo $this->App->print_r2($order['Order']);
//echo $order['Order']['status'];
//echo $this->App->print_r2($evcontrol);

// Przydatne zmienne i konstrukcja html dla kart zamówienia
/* $coism zdefiniowane we kontrolerze, mówi czy zalogowany użytkownik
        może otwierać zamówienia w trybie serwisowym */
$resultForCards = $this->Order->cardsRelated( $order, $evcontrol, $coism );
$order['Order']['isperso'] = $resultForCards['isperso'];

// Potrzebujemy w layoucie wiedzieć, czy zamówienie zawiera choćby 1 kartę z perso, myk:
$this->set("isPersoInTheOrder", $order['Order']['isperso']);
/* Powyższe przeznaczone jest do użycia w kontrolerze, ale jak widać działa również tu.
Mozna też zrobić tak:
$this->viewVars["isPersoInTheOrder"] = $order['Order']['isperso']; */

echo $this->Html->css(    
    $this->App->makeCssJsTable(["order", "order/order"], 'css'),    
    ['inline' => false]
);

echo $this->Html->script(
    $this->App->makeCssJsTable([
        //'classes/ConfirmServant', // potrzebne do pop'upa (i button handling): patrz default layout na dole
        'event', 'order-view', 'order/pay', 'order/servo'
        //, 'order/close-confirm' // potrzebne do pop'upa (i button handling): patrz default layout na dole
        ],
        'js'
    ),    
    ['inline' => false]
); 
echo $this->Ma->walnijJqueryUI();
$this->Ma->displayActions('orders');

if( $order['Order']['nr'] ) {
	$this->set('title_for_layout', $this->Ma->bnr2nrh($order['Order']['nr'], $order['User']['inic'], false));
} else {
    $this->set('title_for_layout', 'Zamówienie (H)');     
}

// kwestie przedpłaty - wartość wyświetlana
$prepaidTxt = $vju['forma_zaliczki']['options'][$order['Order']['forma_zaliczki']];
if( $order['Order']['procent_zaliczki'] ) {
    $prepaidTxt .= ', ' . $order['Order']['procent_zaliczki'] . '%'; }

?>
<div class="orders view">

<?php   
        $nr = $this->Ma->bnr2nrh($order['Order']['nr'], $order['User']['inic'], false);
        if( $order['Order']['isekspres'] ) {
            $nr .= ' <span class="ekspres">EKSPRES</span>';
        }
        
        $zlozone = $this->Ma->md($order['Order']['data_publikacji']);
        // PRZEDPŁATA <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
        if( $order['Order']['stan_zaliczki'] == 'money') {
            $czas = $this->Ma->md($order['Order']['zaliczka_toa'], true);
        } else {
            $czas = null;
        }
        $prepaid_table = [
            'prepaid' => $prepaidTxt,
            'jest_zaliczka' => ($order['Order']['forma_zaliczki'] > 1),            
            'stan_zaliczki' => $order['Order']['stan_zaliczki'],
            'czas' => $czas,
            'clickable' => $order['Order']['zal_clickable'],
            'visible' =>  $order['Order']['zal_visible'], // nie wszystkim wyświetlamy
            'id' => $order['Order']['id']
        ];        
        
        echo $this->element('orders/view/naglowek', array(
                'id' => $order['Order']['id'],
                'numer' => $nr,
                'termin' => $this->Ma->md($order['Order']['stop_day']),
                'zlozone' => $zlozone,
                'ppl' => $prepaid_table,
                'showServo' => $resultForCards['showServo']
        ));
        
        // dl i  uwagi
        echo $this->element('orders/view/dl-uwagi',[
                'order' => $order,
                'prepaid_table' => $prepaid_table,
                'vju' => $vju
        ]);
        
        ?>
	
</div>


<?php

// KARTY zamówienia
echo $this->element('orders/view/cards_related/related', [
        'related' => $resultForCards,
        'weHaveCards' => !empty($order['Card'])
]);

// Przypominajka
if( $order["Customer"]["przypominajka"]) { // prawda tylko, gdy ma być wyświetlona
    $przypominajka = $this->element('orders/pulse', ['widoczne' => true, 'title' => $order["Customer"]["przypominajka"]]);
} else {
    $przypominajka = false;
}
// Zdarzenia pod zamówieniem i formularz akcji
echo $this->element('orders/view/ul_events/ul-events',[
        'order' => $order,
        'evcontrol' => $evcontrol,
        'karty' => $resultForCards['karty'],
        'ludz' => $ludz,
        'evtext' => $evtext,
        'przypominajka' => $przypominajka
]);
//echo $this->App->print_r2($evcontrol);
//echo $this->App->print_r2($order["Customer"]);
?>

<template name="pre-paid">
<?php
    echo $this->element('orders/view/pre-paid-tpl', array( 'prepaid' => $prepaidTxt )); ?>
</template>
<!-- Do zmieniania daty wpłaty -->
<div id="datepicker"></div><div id="komunikat"></div>



