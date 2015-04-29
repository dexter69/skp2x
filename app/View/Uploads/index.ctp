<!--
<?php echo '<pre>';	print_r($uploads); echo  '</pre>'; ?>-->
<div class="uploads index">
	<h2><?php echo __('Uploads'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('filename'); ?></th>
			<th><?php echo $this->Paginator->sort('owner_id'); ?></th>
			<th><?php echo $this->Paginator->sort('filesize'); ?></th>
			<th><?php echo $this->Paginator->sort('role'); ?></th>
			<th><?php echo $this->Paginator->sort('roletxt'); ?></th>
			<!--<th><?php echo $this->Paginator->sort('filemime'); ?></th>-->
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<!--<th><?php echo $this->Paginator->sort('modified'); ?></th>-->
			<th><?php echo $this->Paginator->sort('uuidname'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($uploads as $upload): ?>
	<tr>
		<td><?php echo h($upload['Upload']['id']); ?>&nbsp;</td>

		<td><?php echo h($upload['Upload']['filename']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($upload['Upload']['owner_id'], array('controller' => 'users', 'action' => 'view', $upload['Upload']['owner_id'])); ?>
		</td>
		<td><?php echo h($upload['Upload']['filesize']); ?>&nbsp;</td>
		<td><?php echo h($upload['Upload']['role']); ?>&nbsp;</td>
		<td><?php echo h($upload['Upload']['roletxt']); ?>&nbsp;</td>
		<!--<td><?php echo h($upload['Upload']['filemime']); ?>&nbsp;</td>-->
		<td><?php echo h($upload['Upload']['created']); ?>&nbsp;</td>
		<!--<td><?php echo h($upload['Upload']['modified']); ?>&nbsp;</td>-->
		<td><?php echo h($upload['Upload']['uuidname']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $upload['Upload']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $upload['Upload']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $upload['Upload']['id']), null, __('Are you sure you want to delete # %s?', $upload['Upload']['id'])); ?>
		</td>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Upload'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>
