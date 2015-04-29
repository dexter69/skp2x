<?php 
//echo '<pre>'; print_r($orders); echo '</pre>';
//echo count($orders); 
//echo microtime(true) - $time_start;
//$time_start2 = microtime(true);
//echo $par;
$this->set('title_for_layout', 'Zamówienia');
echo $this->Html->css('order',  null, array('inline' => false));
//echo $this->Html->script(array('jquery', 'common'), array('inline' => false)); 
$this->Ma->displayActions('orders');
$klasa = array(
	'my'=>null, 'accepted'=>null, 'rejected'=>null,
	'wait4check'=>null,	'active'=>null,	'closed'=>null,
	'today'=>null, 'wszystkie'=>null 
);
if( $par == null || $par == 'all-but-priv')
	$klasa['wszystkie'] = 'swieci';
else
	$klasa[$par] = 'swieci';
?>

<div class="orders index">
	<h2 class="hfiltry"><?php echo __('ZAMÓWIENIA (H)'); 
		echo $this->Ma->indexFiltry('orders', $klasa);
	?>
		
	</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nr', 'Numer'); ?></th>
			<!--<th><?php echo $this->Paginator->sort('user_id', 'Opiekun'); ?></th>-->
			<th><?php echo $this->Paginator->sort('Customer.name', 'Klient'); ?></th>
			<!--<th><?php echo $this->Paginator->sort('offset'); ?></th>-->
			<th><?php echo $this->Paginator->sort('stop_day', 'Data zakończenia'); ?></th>
			<th><?php echo $this->Paginator->sort('status', 'STATUS'); ?></th><!--
			<th><?php echo $this->Paginator->sort('inny_adres'); ?></th>
			<th><?php echo $this->Paginator->sort('fullname'); ?></th>
			<th><?php echo $this->Paginator->sort('ulica'); ?></th>
			<th><?php echo $this->Paginator->sort('nr_budynku'); ?></th>
			<th><?php echo $this->Paginator->sort('miasto'); ?></th>
			<th><?php echo $this->Paginator->sort('kod'); ?></th>--><!--
			<th><?php echo $this->Paginator->sort('osoba_kontaktowa'); ?></th>
			<th><?php echo $this->Paginator->sort('tel'); ?></th>
			<th><?php echo $this->Paginator->sort('kraj'); ?></th>
			<th><?php echo $this->Paginator->sort('is_zaliczka'); ?></th>
			<th><?php echo $this->Paginator->sort('wartosc_zaliczki'); ?></th>
			<th><?php echo $this->Paginator->sort('platnosc'); ?></th>
			<th><?php echo $this->Paginator->sort('termin_platnosci'); ?></th>
			<th><?php echo $this->Paginator->sort('comment'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>-->
			<th class="ebutt"></th>
			
	</tr>
	<?php foreach ($orders as $order): ?>
	<tr>
		<!--<td><?php echo h($order['Order']['id']); ?>&nbsp;</td>-->
		<td class="idcolnobold"><?php 
			//if( $order['Order']['nr'] ) // zlecenie ma numer to po prostu id
			//	echo $order['Order']['id'];
			//else // w przeciwnym wypadku z linkiem
				echo $this->Html->link( $order['Order']['id'], array('action' => 'view', $order['Order']['id'])); 
		?>&nbsp;</td>
		
		<!--<td><?php echo h($order['Order']['id'].'/'.NR_SUFIX.'H'); ?>&nbsp;</td>-->
		<td>
			<?php 
			
			//echo $this->Html->link(__($order['Order']['id'].'/'.NR_SUFIX.'H'), array('action' => 'view', $order['Order']['id'])); 
			echo $this->Html->link($this->Ma->bnr2nrh($order['Order']['nr'], $order['User']['inic']), array('action' => 'view', $order['Order']['id']), array('escape' => false)); 
			?>
		</td><!--	
		<td>
			<?php  echo $order['User']['name'];
			//echo $this->Html->link($order['User']['name'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
		</td>-->
		<td>
			<?php echo $this->Html->link($order['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $order['Customer']['id']), array('title' => $order['Customer']['name'])); ?>
		</td>
		<!--<td><?php echo h($order['Order']['offset']); ?>&nbsp;</td>-->
		<td><?php echo $this->Ma->md($order['Order']['stop_day']); ?>&nbsp;</td>
		
		<td><?php echo $this->Ma->status_zamow( $order['Order']['status'] ); ?>&nbsp;</td>
		
		<td class="ebutt"><?php echo $this->Html->link('<div></div>', array('action' => 'edit', $order['Order']['id']), array('class' => 'ebutt',  'escape' =>false)); ?></td>
		
		
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));	
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		
	?>
	</div>
</div>
<?php
//echo microtime(true) - $time_start2; 
?>












<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Dodaj Zamówienie'), array('action' => 'add')); ?></li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Dodaj Kartę'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Kart'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Dodaj Klienta'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Klientów'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		
		
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>
-->