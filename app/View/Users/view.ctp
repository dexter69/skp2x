<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>			
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($user['User']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cards'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Jobs'), array('controller' => 'jobs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Job'), array('controller' => 'jobs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Cards'); ?></h3>
	<?php if (!empty($user['Card'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Customer Id'); ?></th>
		<th><?php echo __('Project Id'); ?></th>
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
	<?php foreach ($user['Card'] as $card): ?>
		<tr>
			<td><?php echo $card['id']; ?></td>
			<td><?php echo $card['user_id']; ?></td>
			<td><?php echo $card['customer_id']; ?></td>
			<td><?php echo $card['project_id']; ?></td>
			<td><?php echo $card['order_id']; ?></td>
			<td><?php echo $card['job_id']; ?></td>
			<td><?php echo $card['name']; ?></td>
			<td><?php echo $card['quantity']; ?></td>
			<td><?php echo $card['price']; ?></td>
			<td><?php echo $card['wzor']; ?></td>
			<td><?php echo $card['comment']; ?></td>
			<td><?php echo $card['status']; ?></td>
			<td><?php echo $card['created']; ?></td>
			<td><?php echo $card['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'cards', 'action' => 'view', $card['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'cards', 'action' => 'edit', $card['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'cards', 'action' => 'delete', $card['id']), null, __('Are you sure you want to delete # %s?', $card['id'])); ?>
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
	<h3><?php echo __('Related Customers'); ?></h3>
	<?php if (!empty($user['Customer'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Fullname'); ?></th>
		<th><?php echo __('Ulica'); ?></th>
		<th><?php echo __('Nr Budynku'); ?></th>
		<th><?php echo __('Miasto'); ?></th>
		<th><?php echo __('Kod'); ?></th>
		<th><?php echo __('Kraj'); ?></th>
		<th><?php echo __('Osoba Kontaktowa'); ?></th>
		<th><?php echo __('Tel'); ?></th>
		<th><?php echo __('Vatno'); ?></th>
		<th><?php echo __('Vatno Txt'); ?></th>
		<th><?php echo __('Waluta'); ?></th>
		<th><?php echo __('Is Zaliczka'); ?></th>
		<th><?php echo __('Wartosc Zaliczki'); ?></th>
		<th><?php echo __('Platnosc'); ?></th>
		<th><?php echo __('Termin Platnosci'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Customer'] as $customer): ?>
		<tr>
			<td><?php echo $customer['id']; ?></td>
			<td><?php echo $customer['user_id']; ?></td>
			<td><?php echo $customer['name']; ?></td>
			<td><?php echo $customer['fullname']; ?></td>
			<td><?php echo $customer['ulica']; ?></td>
			<td><?php echo $customer['nr_budynku']; ?></td>
			<td><?php echo $customer['miasto']; ?></td>
			<td><?php echo $customer['kod']; ?></td>
			<td><?php echo $customer['kraj']; ?></td>
			<td><?php echo $customer['osoba_kontaktowa']; ?></td>
			<td><?php echo $customer['tel']; ?></td>
			<td><?php echo $customer['vatno']; ?></td>
			<td><?php echo $customer['vatno_txt']; ?></td>
			<td><?php echo $customer['waluta']; ?></td>
			<td><?php echo $customer['is_zaliczka']; ?></td>
			<td><?php echo $customer['wartosc_zaliczki']; ?></td>
			<td><?php echo $customer['platnosc']; ?></td>
			<td><?php echo $customer['termin_platnosci']; ?></td>
			<td><?php echo $customer['created']; ?></td>
			<td><?php echo $customer['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'customers', 'action' => 'view', $customer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'customers', 'action' => 'edit', $customer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'customers', 'action' => 'delete', $customer['id']), null, __('Are you sure you want to delete # %s?', $customer['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Events'); ?></h3>
	<?php if (!empty($user['Event'])): ?>
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
	<?php foreach ($user['Event'] as $event): ?>
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
<div class="related">
	<h3><?php echo __('Related Jobs'); ?></h3>
	<?php if (!empty($user['Job'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Offset'); ?></th>
		<th><?php echo __('Stop Day'); ?></th>
		<th><?php echo __('Rodzaj Arkusza'); ?></th>
		<th><?php echo __('Arkusze Netto'); ?></th>
		<th><?php echo __('Dla Laminacji'); ?></th>
		<th><?php echo __('Dla Drukarzy'); ?></th>
		<th><?php echo __('Forum'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Comment'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Job'] as $job): ?>
		<tr>
			<td><?php echo $job['id']; ?></td>
			<td><?php echo $job['user_id']; ?></td>
			<td><?php echo $job['offset']; ?></td>
			<td><?php echo $job['stop_day']; ?></td>
			<td><?php echo $job['rodzaj_arkusza']; ?></td>
			<td><?php echo $job['arkusze_netto']; ?></td>
			<td><?php echo $job['dla_laminacji']; ?></td>
			<td><?php echo $job['dla_drukarzy']; ?></td>
			<td><?php echo $job['forum']; ?></td>
			<td><?php echo $job['status']; ?></td>
			<td><?php echo $job['comment']; ?></td>
			<td><?php echo $job['created']; ?></td>
			<td><?php echo $job['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'jobs', 'action' => 'view', $job['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'jobs', 'action' => 'edit', $job['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'jobs', 'action' => 'delete', $job['id']), null, __('Are you sure you want to delete # %s?', $job['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Job'), array('controller' => 'jobs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Orders'); ?></h3>
	<?php if (!empty($user['Order'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Customer Id'); ?></th>
		<th><?php echo __('Offset'); ?></th>
		<th><?php echo __('Stop Day'); ?></th>
		<th><?php echo __('Inny Adres'); ?></th>
		<th><?php echo __('Fullname'); ?></th>
		<th><?php echo __('Ulica'); ?></th>
		<th><?php echo __('Nr Budynku'); ?></th>
		<th><?php echo __('Miasto'); ?></th>
		<th><?php echo __('Kod'); ?></th>
		<th><?php echo __('Osoba Kontaktowa'); ?></th>
		<th><?php echo __('Tel'); ?></th>
		<th><?php echo __('Kraj'); ?></th>
		<th><?php echo __('Is Zaliczka'); ?></th>
		<th><?php echo __('Wartosc Zaliczki'); ?></th>
		<th><?php echo __('Platnosc'); ?></th>
		<th><?php echo __('Termin Platnosci'); ?></th>
		<th><?php echo __('Comment'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Order'] as $order): ?>
		<tr>
			<td><?php echo $order['id']; ?></td>
			<td><?php echo $order['user_id']; ?></td>
			<td><?php echo $order['customer_id']; ?></td>
			<td><?php echo $order['offset']; ?></td>
			<td><?php echo $order['stop_day']; ?></td>
			<td><?php echo $order['inny_adres']; ?></td>
			<td><?php echo $order['fullname']; ?></td>
			<td><?php echo $order['ulica']; ?></td>
			<td><?php echo $order['nr_budynku']; ?></td>
			<td><?php echo $order['miasto']; ?></td>
			<td><?php echo $order['kod']; ?></td>
			<td><?php echo $order['osoba_kontaktowa']; ?></td>
			<td><?php echo $order['tel']; ?></td>
			<td><?php echo $order['kraj']; ?></td>
			<td><?php echo $order['is_zaliczka']; ?></td>
			<td><?php echo $order['wartosc_zaliczki']; ?></td>
			<td><?php echo $order['platnosc']; ?></td>
			<td><?php echo $order['termin_platnosci']; ?></td>
			<td><?php echo $order['comment']; ?></td>
			<td><?php echo $order['status']; ?></td>
			<td><?php echo $order['created']; ?></td>
			<td><?php echo $order['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'orders', 'action' => 'view', $order['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'orders', 'action' => 'edit', $order['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'orders', 'action' => 'delete', $order['id']), null, __('Are you sure you want to delete # %s?', $order['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
