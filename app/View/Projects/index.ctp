<div class="projects index">
	<h2><?php echo __('Projects'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<!--<th><?php echo $this->Paginator->sort('name'); ?></th>-->
			<th><?php echo $this->Paginator->sort('a_material'); ?></th>
			<th><?php echo $this->Paginator->sort('r_material'); ?></th>
			<th><?php echo $this->Paginator->sort('a_c'); ?></th>
			<th><?php echo $this->Paginator->sort('r_c'); ?></th>
			<th><?php echo $this->Paginator->sort('a_m'); ?></th>
			<th><?php echo $this->Paginator->sort('r_m'); ?></th>
			<th><?php echo $this->Paginator->sort('a_y'); ?></th>
			<th><?php echo $this->Paginator->sort('r_y'); ?></th>
			<th><?php echo $this->Paginator->sort('a_k'); ?></th>
			<th><?php echo $this->Paginator->sort('r_k'); ?></th>
			<th><?php echo $this->Paginator->sort('a_pant'); ?></th>
			<th><?php echo $this->Paginator->sort('r_pant'); ?></th>
			<th><?php echo $this->Paginator->sort('a_lam'); ?></th>
			<th><?php echo $this->Paginator->sort('r_lam'); ?></th>
			<th><?php echo $this->Paginator->sort('mag'); ?></th>
			<th><?php echo $this->Paginator->sort('cmyk_comment'); ?></th>
			<th><?php echo $this->Paginator->sort('a_podklad'); ?></th>
			<th><?php echo $this->Paginator->sort('a_wybr'); ?></th>
			<th><?php echo $this->Paginator->sort('r_podklad'); ?></th>
			<th><?php echo $this->Paginator->sort('r_wybr'); ?></th>
			<th><?php echo $this->Paginator->sort('a_zadruk'); ?></th>
			<th><?php echo $this->Paginator->sort('r_zadruk'); ?></th>
			<th><?php echo $this->Paginator->sort('a_podpis'); ?></th>
			<th><?php echo $this->Paginator->sort('r_podpis'); ?></th>
			<th><?php echo $this->Paginator->sort('a_zdrapka'); ?></th>
			<th><?php echo $this->Paginator->sort('r_zdrapka'); ?></th>
			<th><?php echo $this->Paginator->sort('a_lakpuch'); ?></th>
			<th><?php echo $this->Paginator->sort('r_lakpuch'); ?></th>
			<th><?php echo $this->Paginator->sort('a_lakblys'); ?></th>
			<th><?php echo $this->Paginator->sort('r_lakblys'); ?></th>
			<th><?php echo $this->Paginator->sort('sito_comment'); ?></th>
			<th><?php echo $this->Paginator->sort('isperso'); ?></th>
			<th><?php echo $this->Paginator->sort('perso'); ?></th>
			<th><?php echo $this->Paginator->sort('dziurka'); ?></th>
			<th><?php echo $this->Paginator->sort('chip'); ?></th>
			<th><?php echo $this->Paginator->sort('ksztalt'); ?></th>
			<th><?php echo $this->Paginator->sort('hologram'); ?></th>
			<th><?php echo $this->Paginator->sort('option_comment'); ?></th>
			<th><?php echo $this->Paginator->sort('project_comment'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($projects as $project): ?>
	<tr>
		<td><?php echo h($project['Project']['id']); ?>&nbsp;</td>
		<!--<td><?php echo h($project['Project']['name']); ?>&nbsp;</td>-->
		<td><?php echo h($project['Project']['a_material']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_material']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_c']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_c']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_m']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_m']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_y']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_y']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_k']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_k']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_pant']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_pant']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_lam']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_lam']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['mag']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['cmyk_comment']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_podklad']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_wybr']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_podklad']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_wybr']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_zadruk']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_zadruk']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_podpis']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_podpis']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_zdrapka']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_zdrapka']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_lakpuch']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_lakpuch']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['a_lakblys']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['r_lakblys']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['sito_comment']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['isperso']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['perso']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['dziurka']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['chip']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['ksztalt']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['hologram']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['option_comment']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['project_comment']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['created']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $project['Project']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $project['Project']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $project['Project']['id']), null, __('Are you sure you want to delete # %s?', $project['Project']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Project'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Cards'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Uploads'), array('controller' => 'uploads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
	</ul>
</div>
