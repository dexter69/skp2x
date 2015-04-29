<?php 
//echo '<pre>';	print_r($card); echo  '</pre>'; 
echo $this->Html->script(array('jquery', 'affect'), array('inline' => false)); 
?>
<div class="cards view">
<h2><?php echo __('Karta'); ?></h2>
	<dl id="dexview">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($card['Card']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nazwa Karty'); ?></dt>
		<dd>
			<?php echo h($card['Card']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Opiekun'); ?></dt>
		<dd>
			<?php echo $this->Html->link($card['Owner']['name'], array('controller' => 'users', 'action' => 'view', $card['Owner']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Klient'); ?></dt>
		<dd>
			<?php echo $this->Html->link($card['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $card['Customer']['id'])); ?>
			&nbsp;
		</dd><!--
		<dt><?php echo __('Project'); ?></dt>
		<dd>
			<?php echo $this->Html->link($card['Project']['name'], array('controller' => 'projects', 'action' => 'view', $card['Project']['id'])); ?>
			&nbsp;
		</dd>-->
		<dt><?php echo __('Numer Zamówienia (H)'); ?></dt>
		<dd>
			<?php echo $this->Html->link($this->Ma->bnr2nrh($card['Order']['id']), array('controller' => 'orders', 'action' => 'view', $card['Order']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numer Zlecenia'); ?></dt>
		<dd>
			<?php echo $this->Html->link($card['Job']['id'], array('controller' => 'jobs', 'action' => 'view', $card['Job']['id'])); ?>
			&nbsp;
		</dd>
		
		<dt><?php echo __('Ilość'); ?></dt>
		<dd>
			<?php echo h($card['Card']['quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cena'); ?></dt>
		<dd>
			<?php echo h($card['Card']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wzor'); ?></dt>
		<dd>
			<?php echo h($card['Card']['wzor']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($card['Card']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($card['Card']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($card['Card']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($card['Card']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<!--<h3><?php echo __('Actions'); ?></h3>-->
	<ul>
		<li><?php echo $this->Html->link(__('Lista Kart'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Edytuj Kartę'), array('action' => 'edit', $card['Card']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Dodaj Kartę'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Form->postLink(__('Usuń Kartę'), array('action' => 'delete', $card['Card']['id']), null, __('Are you sure you want to delete # %s?', $card['Card']['id'])); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Lista Zamówień'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Dodaj Zamówienie'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Lista Klientów'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Dodaj Klienta'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		
		<li><?php echo $this->Html->link(__('List Jobs'), array('controller' => 'jobs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Job'), array('controller' => 'jobs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>



<div class="events form">
<?php echo $this->Form->create('Event'); ?>
	<fieldset>
		<!--<legend><?php echo __('Add Event'); ?></legend>-->
	<?php
		//echo $this->Form->input('card_id', array('label' => 'Dotyczy:'));
		//echo $this->Form->input('co', array('default' => ZERO));
		echo $this->Form->input('co', array('default' => ZERO));
		echo $this->Form->input('post', array('label' => 'Komentarz'));
		echo $this->Form->submit($this->Ma->button_val[DTP_OK], array('co'=>DTP_OK, 'name'=>'klik', 'class'=>'affect', 'req'=>$this->Ma->button_req[DTP_OK]  ));
		echo $this->Form->submit($this->Ma->button_val[DTP_NO], array('co'=>DTP_NO, 'name'=>'klik', 'class'=>'affect', 'req'=>$this->Ma->button_req[DTP_NO] ));
		echo $this->Form->submit($this->Ma->button_val[PERSO_OK], array('co'=>PERSO_OK, 'name'=>'klik', 'class'=>'affect', 'req'=>$this->Ma->button_req[PERSO_OK]  ));
		echo $this->Form->submit($this->Ma->button_val[PERSO_NO], array('co'=>PERSO_NO, 'name'=>'klik', 'class'=>'affect', 'req'=>$this->Ma->button_req[PERSO_NO]  ));
		
		
		
	?>	
	</fieldset>
<?php echo $this->Form->end(); 

?>
</div>



<div class="related">
	<h3><?php echo __('Załączone Pliki'); ?></h3>
	<?php if (!empty($card['Upload'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th><!--
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Description'); ?></th>-->
		<th><?php echo __('Nazwa Pliku'); ?></th>
		<th><?php echo __('Rozmiar'); ?></th><!--
		<th><?php echo __('Filemime'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>-->
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($card['Upload'] as $upload): ?>
		<tr>
			<td><?php echo $upload['id']; ?></td><!--
			<td><?php echo $upload['title']; ?></td>
			<td><?php echo $upload['description']; ?></td>-->
			<td><?php echo $upload['filename']; ?></td>
			<td><?php echo $upload['filesize']; ?></td><!--
			<td><?php echo $upload['filemime']; ?></td>
			<td><?php echo $upload['created']; ?></td>
			<td><?php echo $upload['modified']; ?></td>-->
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'uploads', 'action' => 'view', $upload['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'uploads', 'action' => 'edit', $upload['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'uploads', 'action' => 'delete', $upload['id']), null, __('Are you sure you want to delete # %s?', $upload['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table><!--
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
		</ul>
	</div>-->
	
</div>

<div class="related">
	<h3><?php echo __('Related Events'); ?></h3>
	<?php if (!empty($card['Event'])): ?>
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
	<?php foreach ($card['Event'] as $event): ?>
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

