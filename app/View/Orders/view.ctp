<?php
//echo $this->App->print_r2($order['Order']);
//echo $order['Order']['status'];

echo $this->Html->css(    
    $this->App->makeCssJsTable(["order", "order/order"], 'css'),    
    ['inline' => false]
);

echo $this->Html->script(
    $this->App->makeCssJsTable(['event', 'order-view', 'order/pay', 'order/servo'], 'js'),    
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
        
        // Przydatne zmienne i konstrukcja html dla kart zamówienia
        /* $coism Szdefiniowane we kontrolerze, mówi czy zalogowany użytkownik
                może otwierać zamówienia w trybie serwisowym */
        $resultForCards = $this->Order->cardsRelated( $order, $evcontrol, $coism );

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

// Zdarzenia pod zamówieniem i formularz akcji
echo $this->element('orders/view/ul_events/ul-events',[
        'order' => $order,
        'evcontrol' => $evcontrol,
        'karty' => $resultForCards['karty'],
        'ludz' => $ludz,
        'evtext' => $evtext
]);

?>

<template name="pre-paid">
<?php
    echo $this->element('orders/view/pre-paid-tpl', array( 'prepaid' => $prepaidTxt )); ?>
</template>
<!-- Do zmieniania daty wpłaty -->
<div id="datepicker"></div><div id="komunikat"></div>




