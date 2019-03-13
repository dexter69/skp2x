<?php
//echo $this->App->print_r2($order['Order']);
//echo $order['Order']['status'];

echo $this->Html->css(array('order', 'order/order.css?v=' . time()), array('inline' => false));
echo $this->Html->script(array('event', 'order-view', 'order/pay', 'order/servo.js?v=' . time()), array('inline' => false)); 
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
            $czas = null; }
        $prepaid_table = array(
            'prepaid' => $prepaidTxt,
            'jest_zaliczka' => ($order['Order']['forma_zaliczki'] > 1),            
            'stan_zaliczki' => $order['Order']['stan_zaliczki'],
            'czas' => $czas,
            'clickable' => $order['Order']['zal_clickable'],
            'visible' =>  $order['Order']['zal_visible'], // nie wszystkim wyświetlamy
            'id' => $order['Order']['id']
        );	
        
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
$karty = $resultForCards['karty']; // potrzebne poniżej w "ul-events"
?>



<div class="ul-events">
	<?php $this->Ma->kontrolka_ord($order, $evcontrol);	?>
	<ul>
            <?php
            $start = count($order['Event'])-1;
            for ($i = $start; $i >=0; $i--) {
                    $event = $order['Event'][$i];
                    echo $this->Html->tag('li', null, array('class' => 'post'));
                            echo $this->Html->tag('div', null, array('class' => 'postinfo'));
                            /*
                            if( $event['card_id'] ) $co = //'<span>kartę: </span>'.
                                            $karty[$event['card_id']]; 
                            else
                            */
                            switch( $event['co'] ) {
                                case put_kom:
                                        $co ='';
                                break;
                                case p_ov:
                                case p_no: 
                                case p_ok: 
                                case d_no: 
                                case d_ok:
                                case h_ov: 
                                        if(	array_key_exists( $event['card_id'], $karty ) ) {
                                                $co = $karty[$event['card_id']];
                                        } else {
                                                $co = "(USUNIĘTA)";
                                        }                                             
                                break;
                                default:
                                        $co ='';
                            }

                            //substr($event['created'],0,10)

                            if( $event['co'] == put_kom && $event['card_id']  ) {
                                    $kartkomm = ' odnośnie karty:';
                                    foreach( $order['Card'] as $karta )
                                    if( $karta['id'] == $event['card_id'] )
                                            $kartkomm .= ' ' . $karta['name'];
                            }

                            else
                                    $kartkomm = null;

                            echo '<p>'.$ludz[$event['user_id']]['name'].'</p>'.'<p class="gibon"><span class="' . 
                                            //$this->Ma->evtext[$event['co']]['class'].'">' . 
                                            $evtext[$event['co']]['class'] . '">' .
                                            //$this->Ma->evtext[$event['co']][$ludz[$event['user_id']]['k']]. ' ' .
                                            $evtext[$event['co']][$ludz[$event['user_id']]['k']]. ' ' .
                                            $co . $kartkomm .

                                            '</span></p>'.'<span>'.$this->Ma->mdt($event['created']).'</span>';
                            $list = array( nl2br($event['post']) );

                            echo $this->Html->tag('/div');
                            echo $this->Html->tag('div');
                                    echo $this->Html->nestedList(
                                    $list,
                                    array('class'=>'olevent'),
                                    null,
                                    'ol'
                                    );
                            echo $this->Html->tag('span', $i + 1, array('class' => 'event_nr'));	
                            echo $this->Html->tag('/div');

                    echo $this->Html->tag('/li');
            } ?>
	</ul>
</div>

<template name="pre-paid">
<?php
    echo $this->element('orders/view/pre-paid-tpl', array( 'prepaid' => $prepaidTxt )); ?>
</template>
<!-- Do zmieniania daty wpłaty -->
<div id="datepicker"></div><div id="komunikat"></div>




