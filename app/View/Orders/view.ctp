<?php
$pokaz = true; // decyduje o wyswietlaniu w linii ~121 -> $order

echo $this->Html->css(array('order', 'order/order.css?v=201804041230'), array('inline' => false));
echo $this->Html->script(array('event', 'order-view', 'order/pay'), array('inline' => false)); 
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
if( $pokaz ) { echo $this->App->print_r2($order); }
?>

	
<div class="related">
	<!--<h3>-->
	<?php echo $this->Ma->viewheader('KARTY', array('class' => 'margin02') ); 
	// Jezeli użytkownik może zmieniać status kart, to musimy nadać odpowiednią klasę
	if( $order['Order']['statusKartyMoznaModyfikowac'] ) {
		$ta_klasa = "card_status_fix clickable";
	} else {
		$ta_klasa = "card_status_fix";
	}
	if (!empty($order['Card'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th class="card_id_fix"><?php echo 'Id'; ?></th>
		<th><?php echo __('Nazwa'); ?></th>
		<th class="card_opcje_fix">Opcje</th>
		<!--<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Klient'); ?></th>
		<th><?php echo __('Order Id'); ?></th>-->
		<th class="card_zlec_fix"><?php echo 'Zlecenie(P)'; ?></th>		
		<th class="card_ilosc_fix"><?php echo 'Ilość'; ?></th>
		<th class="card_cena_fix"><?php echo 'Cena'; ?></th>
		<th class="<?php echo $ta_klasa; ?>"><?php echo 'Status'; ?></th>
		<?php
			if( $evcontrol['bcontr'][push4checking] ) {
				echo '<th class="card_dpcheck_fix">'.'D'.'</th>'.'<th class="card_dpcheck_fix">'.'P'.'</th>';
			}
		?>	
		
	</tr>
	<?php $k=0; $sigma = 0;
		foreach ($order['Card'] as $card): ?>
		<?php $karty[ $card['id'] ]= $card['name']; ?>
		<tr>
			<td class="card_id_fix"><?php echo $card['id']; ?></td>
			<td><?php echo $this->Html->link($card['name'], array(
						'controller' => 'cards', 'action' => 'view', $card['id']
						), array('title' => $card['name']));	?> </td>
			<td class="card_opcje_fix"><?php if( $card['isperso'] ) echo '<span class="perso">P</span>';
			?>
			</td>			
			<td class="card_zlec_fix"><?php
				if( $card['job_nr'] ) {
					echo $this->Html->link($this->Ma->bnr2nrj($card['job_nr'], null)/*$card['job_nr']*/, array(
						'controller' => 'jobs', 'action' => 'view', $card['job_id']),
						array('escape' => false)
					);
				}				
				$this->Ma->bnr2nrj($card['job_nr'], null)
			?>	
			</td>
			<td class="card_ilosc_fix"><?php 
                            $sigma += $card['quantity'];
                            echo $this->Ma->tys($card['quantity']); ?></td>			
			<?php
			// cena - chcemy, że gdy jest 0, to by program wypisywał "UWAGI"
				if ( $card['price'] == 0 ) {
					$cenka = 'UWAGI';
				} else {
					$cenka = $this->Ma->colon($card['price']);
				}				
			?>
			<td class="card_cena_fix"><?php echo $cenka;?></td>
			 <td class="card_status_fix"><?php 
			 		if( $card['status'] == PRIV && $order['Order']['id'] )
						echo 'ZAŁĄCZONA';
					else
						echo $this->Ma->status_karty($card['status']); ?></td>
			<?php
				if( $evcontrol['bcontr'][push4checking] ) {
					$d_checked = $p_checked = false;
					switch($card['status']) {						
						case DNO:
						case DNOPOK:
						case W4D:
						case W4DPOK:
							$d_checked = true;
						break;
						case W4PDOK:
						case DOKPNO:
							 $p_checked = true;
						break;
						case W4DPNO:
						case W4DP:
						case W4PDNO:
						case DNOPNO: $d_checked = $p_checked = true;
						break;
					}
					// 'ard' w inpucie specjanie
					$dtp =  $this->Form->input('ard.'.$k.'.D', array(
					'type' => 'checkbox',
					'checked'=> $d_checked,
					//'checked' => true,
					'label' => false,
					'div' => false,
					'class' => 'dlajoli',
					'idlike' => 'Card'.$k.'D',
					'disabled' => $d_checked
					//'order_id' => $oid,
					//'card_id' => $cid,
					//'ilosc' => $ile
					));
					$per =  $this->Form->input('ard.'.$k.'.P', array(
						'type' => 'checkbox',
						'checked'=> $p_checked,
						'label' => false,
						'div' => false,
						'class' => 'dlajoli',
						'idlike' => 'Card'.$k++.'P',
						'disabled' => !$card['isperso'] || $p_checked
					));
					echo '<td class="card_dpcheck_fix">'.$dtp.'</td>'.'<td class="card_dpcheck_fix">'.$per.'</td>';
				}
			?>						
		</tr>
	<?php endforeach; 
            if( $sigma ) {
                echo '<tr class="sumainfo"><td></td><td></td><td></td><td class="sumatd">Suma:</td><td class="card_ilosc_fix">' . $this->Ma->tys($sigma) .
                        '</td><td></td><td></td></tr>';
            }
        ?>  
	</table>
<?php endif; ?>

</div>




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
                                            $co = $karty[$event['card_id']]; 
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
<?php
    //echo '<pre>';	print_r($order); echo  '</pre>';



