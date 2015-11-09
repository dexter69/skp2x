<div class="proofs index">
	<h2><?php echo __('Proofs'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('card_id'); ?></th>
			<th><?php echo $this->Paginator->sort('eng'); ?></th>
			<th><?php echo $this->Paginator->sort('cr'); ?></th>
			<th><?php echo $this->Paginator->sort('waluta'); ?></th>
			<th><?php echo $this->Paginator->sort('a_kolor'); ?></th>
			<th><?php echo $this->Paginator->sort('r_kolor'); ?></th>
			<th><?php echo $this->Paginator->sort('size'); ?></th>
			<th><?php echo $this->Paginator->sort('uwagi'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($proofs as $proof): ?>
	<tr>
		<td><?php echo h($proof['Proof']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($proof['Card']['name'], array('controller' => 'cards', 'action' => 'view', $proof['Card']['id'])); ?>
		</td>
		<td><?php echo h($proof['Proof']['eng']); ?>&nbsp;</td>
		<td><?php echo h($proof['Proof']['cr']); ?>&nbsp;</td>
		<td><?php echo h($proof['Proof']['waluta']); ?>&nbsp;</td>
		<td><?php echo h($proof['Proof']['a_kolor']); ?>&nbsp;</td>
		<td><?php echo h($proof['Proof']['r_kolor']); ?>&nbsp;</td>
		<td><?php echo h($proof['Proof']['size']); ?>&nbsp;</td>
		<td><?php echo h($proof['Proof']['uwagi']); ?>&nbsp;</td>
		<td><?php echo h($proof['Proof']['created']); ?>&nbsp;</td>
		<td><?php echo h($proof['Proof']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $proof['Proof']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $proof['Proof']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $proof['Proof']['id']), array(), __('Are you sure you want to delete # %s?', $proof['Proof']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Proof'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Cards'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
	</ul>
</div>
