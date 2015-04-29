<?php
echo $this->Html->css('order', null, array('inline' => false));
echo $this->Html->script(array('jquery', 'affect'), array('inline' => false)); 
//echo '<pre>'; print_r($order); echo '</pre>';
//echo '<pre>'; print_r($cards); echo '</pre>';
//order-affect
?>
<div class="orders view">
<h2><?php echo __('Zamówienie (H)'); ?></h2>
	<dl id="dexview">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Opiekun'); ?></dt>
		<dd>
			<?php echo $this->Html->link($order['User']['name'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Klient'); ?></dt>
		<dd>
			<?php echo $this->Html->link($order['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $order['Customer']['id'])); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Data Zakończenia'); ?></dt>
		<dd>
			<?php echo h($order['Order']['stop_day']); ?>
			&nbsp;
		</dd>
		

		<dt><?php echo __('Osoba Kontaktowa'); ?></dt>
		<dd>
			<?php echo h($order['Order']['osoba_kontaktowa']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tel'); ?></dt>
		<dd>
			<?php echo h($order['Order']['tel']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Termin Platnosci'); ?></dt>
		<dd>
			<?php echo h($order['Order']['termin_platnosci']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($order['Order']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		
		<dd>
			<?php echo h($this->Ma->order_stat[$order['Order']['status']]); ?>
			&nbsp;
		</dd>
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
	</dl>
</div>
<div class="actions">
	<!--<h3><?php echo __('Actions'); ?></h3>-->
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

<div class="events form">
<?php echo $this->Form->create('Event'); ?>
	<fieldset>
		<!--<legend><?php echo __('Add Event'); ?></legend>-->
	<?php
		echo $this->Form->input('card_id', array('label' => 'Dotyczy:'));
		//echo $this->Form->input('co', array('default' => ZERO));
		echo $this->Form->hidden('co', array('default' => ZERO));
		echo $this->Form->input('post', array('label' => 'Komentarz'));
		echo $this->Form->submit($this->Ma->button_val[PUBLI], array('co'=>PUBLI, 'name'=>'klik', 'class'=>'affect', 'req'=>$this->Ma->button_req[PUBLI] ));
		/*
		echo $this->Form->submit($this->Ma->button_val[DTP_OK], array('co'=>DTP_OK, 'name'=>'klik', 'class'=>'affect', 'req'=>$this->Ma->button_req[DTP_OK]  ));
		echo $this->Form->submit($this->Ma->button_val[DTP_NO], array('co'=>DTP_NO, 'name'=>'klik', 'class'=>'affect', 'req'=>$this->Ma->button_req[DTP_NO] ));
		echo $this->Form->submit($this->Ma->button_val[PERSO_OK], array('co'=>PERSO_OK, 'name'=>'klik', 'class'=>'affect', 'req'=>$this->Ma->button_req[PERSO_OK]  ));
		echo $this->Form->submit($this->Ma->button_val[PERSO_NO], array('co'=>PERSO_NO, 'name'=>'klik', 'class'=>'affect', 'req'=>$this->Ma->button_req[PERSO_NO]  ));
		*/
		
		
	?>	
	</fieldset>
<?php echo $this->Form->end(); 
//echo $this->Form->end(__('Submit')); 
?>
</div>

<div class="related">
	<h3><?php echo __('Related Cards'); ?></h3>
	<?php if (!empty($order['Card'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Customer Id'); ?></th>
		<th><?php echo __('Order Id'); ?></th>
		<th><?php echo __('Job Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Wzor'); ?></th>
		<th><?php echo __('Comment'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($order['Card'] as $card): ?>
		<tr>
			<td><?php echo $card['id']; ?></td>
			<td><?php echo $card['user_id']; ?></td>
			<td><?php echo $card['customer_id']; ?></td>
			<td><?php echo $card['order_id']; ?></td>
			<td><?php echo $card['job_id']; ?></td>
			<td><?php echo $card['name']; ?></td>
			<td><?php echo $this->Ma->tys($card['quantity']); ?></td>
			<td><?php echo $this->Ma->colon($card['price']);
			 ?></td>
			<td><?php echo $card['wzor']; ?></td>
			<td><?php echo $card['comment']; ?></td>
			<td><?php echo $card['status']; ?></td>
			<td><?php echo $card['created']; ?></td>
			<td><?php echo $card['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('V'), array('controller' => 'cards', 'action' => 'view', $card['id'])); ?>
				<?php echo $this->Html->link(__('E'), array('controller' => 'cards', 'action' => 'edit', $card['id'])); ?>
				<?php echo $this->Form->postLink(__('D'), array('controller' => 'cards', 'action' => 'delete', $card['id']), null, __('Are you sure you want to delete # %s?', $card['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
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

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
