<?php
echo 'druknij.ctp';
//echo '<pre>';	print_r($order); echo  '</pre>';
echo $this->Html->css('order', null, array('inline' => false));
echo $this->Html->script(array('event'), array('inline' => false)); 
$this->Ma->displayActions('orders');

if( $order['Order']['nr'] )
	$this->set('title_for_layout', $this->Ma->bnr2nrh($order['Order']['nr'], $order['User']['inic'], false));
else
	$this->set('title_for_layout', 'Zamówienie (H)');
//echo '<pre>';	print_r($evcontrol); echo  '</pre>';
//echo count($order['Card']).'<br>';
//echo '<pre>';	print_r($order); echo  '</pre>';
//echo '<pre>';	print_r($ludz); echo  '</pre>';
//echo '<pre>';	print_r($order['Event']); echo  '</pre>';
//echo '<pre>';	print_r($links); echo  '</pre>';
//echo '<pre>';	print_r($evcontrol['ile']); echo  '</pre>';
//echo '<pre>';	print_r($vju); echo  '</pre>';

?>
<div class="orders view">
<h2><?php echo 'Zamówienie (H)'.$this->Ma->editlink('order', $order['Order']['id']); ?></h2>
	<?php //$this->Ma->nawiguj( $links, $order['Order']['id'] ); //nawigacyjne do dodaj, usuń, edycja itp. ?>
	<dl id="dexview">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numer'); ?></dt>
		<dd class="corenr">
			<?php echo $this->Ma->bnr2nrh($order['Order']['nr'], $order['User']['inic']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Klient'); ?></dt>
		<dd>
			<?php echo $this->Html->link($order['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $order['Customer']['id'])); ?>
			&nbsp;
		</dd>
		
		<dt><?php echo __('Opiekun'); ?></dt>
		<dd>
			<?php echo $order['User']['name'];
				//echo $this->Html->link($order['User']['name'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
			&nbsp;
		</dd>
		
		<dt><?php echo __('Złożone'); ?></dt>
		<dd>
			<?php echo $this->Ma->md($order['Order']['data_publikacji']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Data Zakończenia'); ?></dt>
		<dd>
			<?php echo $this->Ma->md($order['Order']['stop_day']); ?>
			&nbsp;
			<?php if( $order['Order']['isekspres'] )
					echo '<span class="ekspres">EKSPRES</span>'; ?>
			&nbsp;
		</dd>
		

		<dt><?php echo __('Osoba Kontaktowa'); ?></dt>
		<dd>
			<?php echo h($order['Order']['osoba_kontaktowa']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telefon'); ?></dt>
		<dd>
			<?php echo h($order['Order']['tel']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Przedpłata' ?></dt>
		<dd>
			<?php echo $vju['forma_zaliczki']['options'][$order['Order']['forma_zaliczki']];
			if( $order['Order']['procent_zaliczki'] )
				echo ', ' . $order['Order']['procent_zaliczki'] . '%';
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('Forma Płatnosci'); ?></dt>
		<dd>
			<?php echo $vju['forma_platnosci']['options'][$order['Order']['forma_platnosci']];
			if( ($order['Order']['forma_platnosci'] == PRZE || $order['Order']['forma_platnosci'] == CASH)
					&& $order['Order']['termin_platnosci'] )
						echo ', ' . $order['Order']['termin_platnosci'] . ' dni';
			?>
			&nbsp;
		</dd>
						
		<dt><?php echo __('Uwagi'); ?></dt>
		<dd>
			<?php echo nl2br($order['Order']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h( $this->Ma->order_stat[$order['Order']['status']] ); ?>
			&nbsp;
			
		</dd>
		<dt><?php echo __('Dane do faktury'); ?></dt>
		<dd>
			<?php 
				echo  $order['AdresDoFaktury']['name'].', ul. '.$order['AdresDoFaktury']['ulica'].' '.$order['AdresDoFaktury']['nr_budynku'].', '.
					  $order['AdresDoFaktury']['kod'].' '.$order['AdresDoFaktury']['kraj']; 
			?>
			&nbsp;
			
		</dd>
		<dt><?php echo __('Adres dostawy'); ?></dt>
		<dd>
			<?php 
			
				if( $order['Order']['siedziba_id'] == $order['Order']['wysylka_id'] )
					echo 'NA ADRES FAKTURY';
				else
					echo	$order['AdresDostawy']['name'].', ul. '.$order['AdresDostawy']['ulica'].' '.
							$order['AdresDostawy']['nr_budynku'].', '.
					  		$order['AdresDostawy']['kod'].' '.$order['AdresDostawy']['kraj']; 
			?>
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
</div>

<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Zamówień'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Edytuj Zamówienie'), array('action' => 'edit', $order['Order']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Dodaj Zamówienie'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Form->postLink(__('Usuń Zamówienie'), array('action' => 'delete', $order['Order']['id']), null, __('Are you sure you want to delete # %s?', $order['Order']['id'])); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Lista Kart'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Dodaj Kartę'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Lista Klientów'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Dodaj Klienta'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		
		
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>
-->
<!-- <?php $this->Ma->kontrolka_ord($order, $evcontrol);	?>	-->
	
<div class="related">
	<!--<h3>-->
	<?php echo $this->Ma->viewheader('KARTY', array('class' => 'margin02') ); ?>
		
	<!--</h3>-->
	<?php if (!empty($order['Card'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nazwa'); ?></th>
		<th>Opcje</th>
		<!--<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Klient'); ?></th>
		<th><?php echo __('Order Id'); ?></th>-->
		<th><?php echo __('Zlecenie(P)'); ?></th>
		
		<th><?php echo __('Ilość'); ?></th>
		<th><?php echo __('Cena'); ?></th>
		<th><?php echo __('Status'); ?></th><!--
		<th><?php echo __('Wzor'); ?></th>
		<th><?php echo __('Comment'); ?></th>
		
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>-->
	</tr>
	<?php foreach ($order['Card'] as $card): ?>
		<?php $karty[ $card['id'] ]= $card['name']; ?>
		<tr>
			<td><?php echo $card['id']; ?></td>
			<td><?php echo $this->Html->link($card['name'], array(
						'controller' => 'cards', 'action' => 'view', $card['id']
						));	?> </td>
			<td><?php if( $card['isperso'] ) echo '<span class="perso">P</span>';
			?>
			</td>
			<!--<td><?php echo $card['user_id']; ?></td>
			<td><?php 
				//echo $card['customer_id']; 
				echo $this->Html->link($order['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $card['customer_id'])); 
			?></td>
			<td><?php echo $card['order_id']; ?></td>
			<td><?php echo $card['job_id']; ?></td>-->
			<td><?php
				if( $card['job_nr'] ) {
					echo $this->Html->link($this->Ma->bnr2nrj($card['job_nr'], null)/*$card['job_nr']*/, array(
						'controller' => 'jobs', 'action' => 'view', $card['job_id']),
						array('escape' => false)
					);
				}
				
				$this->Ma->bnr2nrj($card['job_nr'], null)
			?>	
			</td>
			<td><?php echo $this->Ma->tys($card['quantity']); ?></td>
			<td><?php echo $this->Ma->colon($card['price']);
			 ?></td>
			 <td><?php 
			 		if( $card['status'] == PRIV && $order['Order']['id'] )
						echo 'ZAŁĄCZONA';
					else
						echo $this->Ma->status_karty($card['status']); ?></td><!--
			 
			<td><?php echo $card['wzor']; ?></td>
			<td><?php echo $card['comment']; ?></td>
			
			<td><?php echo $card['created']; ?></td>
			<td><?php echo $card['modified']; ?></td>-->
			<!--
			<td class="actions">
				<?php echo $this->Html->link(__('V'), array('controller' => 'cards', 'action' => 'view', $card['id'])); ?>
				<?php echo $this->Html->link(__('E'), array('controller' => 'cards', 'action' => 'edit', $card['id'])); ?>
				<?php echo $this->Form->postLink(__('D'), array('controller' => 'cards', 'action' => 'delete', $card['id']), null, __('Are you sure you want to delete # %s?', $card['id'])); ?>
			</td>-->
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
<!--
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		</ul>
	</div>-->
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
							case p_no: 
							case p_ok: 
							case d_no: 
							case d_ok: 
								$co = $karty[$event['card_id']]; 
							break;
							default:
								$co ='zamówienie';
						}
						
					//substr($event['created'],0,10)
					
					echo '<p>'.$ludz[$event['user_id']]['name'].'</p>'.'<p class="gibon"><span class="'.$this->Ma->evtext[$event['co']]['class'].'">'.$this->Ma->evtext[$event['co']][$ludz[$event['user_id']]['k']].' '.$co.'</span></p>'.'<span>'.$this->Ma->mdt($event['created']).'</span>';
					$list = array(
						//'<span class="'.$this->Ma->evtext[$event['co']]['class'].'">'.$this->Ma->evtext[$event['co']][$ludz[$event['user_id']]['k']].'</span>'.'&nbsp;'.$co,
						$event['post']
					);
					
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


<!--
<div class="related">-->
<!--
	<h3><?php echo __('Related Events'); ?></h3>
	<?php if (!empty($order['Event'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Order Id'); ?></th>
		<th><?php echo __('Job Id'); ?></th>
		<th><?php echo __('Card Id'); ?></th>
		<th><?php echo __('Co'); ?></th>
		<th><?php echo __('Post'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($order['Event'] as $event): ?>
		<tr>
			<td><?php echo $event['id']; ?></td>
			<td><?php echo $event['user_id']; ?></td>
			<td><?php echo $event['order_id']; ?></td>
			<td><?php echo $event['job_id']; ?></td>
			<td><?php echo $event['card_id']; ?></td>
			<td><?php echo $event['co']; ?></td>
			<td><?php echo $event['post']; ?></td>
			<td><?php echo $event['created']; ?></td>
			<td><?php echo $event['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'events', 'action' => 'view', $event['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'events', 'action' => 'edit', $event['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'events', 'action' => 'delete', $event['id']), null, __('Are you sure you want to delete # %s?', $event['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
	-->
	<!--
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		</ul>
	</div>-->
<!--</div>-->

