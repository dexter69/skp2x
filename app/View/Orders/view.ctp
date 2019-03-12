<?php
//echo $this->App->print_r2($order['Order']);

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

        echo $this->element('orders/view/naglowek', array(
                'id' => $order['Order']['id'],
                'numer' => $nr,
                'termin' => $this->Ma->md($order['Order']['stop_day']),
                'zlozone' => $zlozone,
                'ppl' => $prepaid_table
        )); ?>
    
	<?php //$this->Ma->nawiguj( $links, $order['Order']['id'] ); //nawigacyjne do dodaj, usuń, edycja itp. ?>
	<dl id="dexview" class="in-order">
		
		<dt><?php echo 'Klient'; ?></dt>
		<dd>
			<?php
				if( $order['Order']['newcustomer'] ) { $rodz = " [N]"; } else { $rodz = " [S]"; }
				echo $this->Html->link($order['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $order['Customer']['id']))
				. '<span class="rodzcust">' . "$rodz</span>";
			?>
			&nbsp;
		</dd>
		
		<dt><?php echo 'Opiekun'; ?></dt>
		<dd>
			<?php echo $order['User']['name'];
				//echo $this->Html->link($order['User']['name'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
			&nbsp;
		</dd>
                <?php
                // PRZEDPŁATA
                 echo $this->element('orders/view/pre-dt-dd', $prepaid_table ); ?>
                
		<dt><?php echo 'Forma Płatnosci'; ?></dt>
		<dd><?php 
                    echo $vju['forma_platnosci']['options'][$order['Order']['forma_platnosci']];
                    if( ($order['Order']['forma_platnosci'] == PRZE || $order['Order']['forma_platnosci'] == CASH)
                        && $order['Order']['termin_platnosci'] )
                        { echo ', ' . $order['Order']['termin_platnosci'] . ' dni'; }
			?>
			&nbsp;
		</dd>
		<dt><?php echo 'Waluta'; ?></dt>
		<dd><?php echo $order['Customer']['waluta']; ?></dd>		
		<dt><?php echo __('Status'); ?></dt>
		<dd><?php echo $this->Ma->status_zamow($order['Order']['status']);	?>
			&nbsp;			
		</dd>
		<dt><?php echo 'Dane do faktury'; ?></dt>
		<dd><?php echo $this->Ma->adresFaktury($order); ?> &nbsp;</dd>
		<dt><?php echo 'Adres dostawy'; ?></dt>
		<dd><?php echo $this->Ma->adresDostawy($order); ?>&nbsp;</dd>
		<dt><?php echo __('Kontakt'); ?></dt>
		<dd>
			<?php echo $order['Order']['osoba_kontaktowa']; ?>
			&nbsp;
                        <?php echo '<br>tel. ' . h($order['Order']['tel']); ?>
			&nbsp;
             
		</dd>		
		<!--
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($order['Order']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($order['Order']['modified']); ?>
			&nbsp;
		</dd>
		-->
	</dl>
        <div class="order-uwagi">
            <p>Uwagi:</p>
            <?php echo nl2br($order['Order']['comment']); ?>&nbsp;
        </div>
</div>


<?php

// KARTY zamówienia
echo $this->element('orders/view/cards_related/related');
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

<?php
	//echo '<pre>';	print_r($order); echo  '</pre>';	
	echo "<div class='test'>" . $tcards . "</div>";
?>

<template name="pre-paid">
<?php
    echo $this->element('orders/view/pre-paid-tpl', array( 'prepaid' => $prepaidTxt )); ?>
</template>
<!-- Do zmieniania daty wpłaty -->
<div id="datepicker"></div><div id="komunikat"></div>




