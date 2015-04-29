<?php 
echo '<pre>';	print_r($upload); echo  '</pre>';
?>
<div class="uploads view">
<h2><?php echo __('Upload'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($upload['Upload']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($upload['Upload']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($upload['Upload']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Filename'); ?></dt>
		<dd>
			<?php echo h($upload['Upload']['filename']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Filesize'); ?></dt>
		<dd>
			<?php echo h($upload['Upload']['filesize']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Filemime'); ?></dt>
		<dd>
			<?php echo h($upload['Upload']['filemime']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($upload['Upload']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($upload['Upload']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Upload'), array('action' => 'edit', $upload['Upload']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Upload'), array('action' => 'delete', $upload['Upload']['id']), null, __('Are you sure you want to delete # %s?', $upload['Upload']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Uploads'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Upload'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Projects'); ?></h3>
	<?php if (!empty($upload['Project'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('A Material'); ?></th>
		<th><?php echo __('R Material'); ?></th>
		<th><?php echo __('A C'); ?></th>
		<th><?php echo __('R C'); ?></th>
		<th><?php echo __('A M'); ?></th>
		<th><?php echo __('R M'); ?></th>
		<th><?php echo __('A Y'); ?></th>
		<th><?php echo __('R Y'); ?></th>
		<th><?php echo __('A K'); ?></th>
		<th><?php echo __('R K'); ?></th>
		<th><?php echo __('A Pant'); ?></th>
		<th><?php echo __('R Pant'); ?></th>
		<th><?php echo __('A Lam'); ?></th>
		<th><?php echo __('R Lam'); ?></th>
		<th><?php echo __('Mag'); ?></th>
		<th><?php echo __('Cmyk Comment'); ?></th>
		<th><?php echo __('A Podklad'); ?></th>
		<th><?php echo __('A Wybr'); ?></th>
		<th><?php echo __('R Podklad'); ?></th>
		<th><?php echo __('R Wybr'); ?></th>
		<th><?php echo __('A Zadruk'); ?></th>
		<th><?php echo __('R Zadruk'); ?></th>
		<th><?php echo __('A Podpis'); ?></th>
		<th><?php echo __('R Podpis'); ?></th>
		<th><?php echo __('A Zdrapka'); ?></th>
		<th><?php echo __('R Zdrapka'); ?></th>
		<th><?php echo __('A Lakpuch'); ?></th>
		<th><?php echo __('R Lakpuch'); ?></th>
		<th><?php echo __('A Lakblys'); ?></th>
		<th><?php echo __('R Lakblys'); ?></th>
		<th><?php echo __('Sito Comment'); ?></th>
		<th><?php echo __('Isperso'); ?></th>
		<th><?php echo __('Perso'); ?></th>
		<th><?php echo __('Dziurka'); ?></th>
		<th><?php echo __('Chip'); ?></th>
		<th><?php echo __('Ksztalt'); ?></th>
		<th><?php echo __('Hologram'); ?></th>
		<th><?php echo __('Option Comment'); ?></th>
		<th><?php echo __('Project Comment'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($upload['Project'] as $project): ?>
		<tr>
			<td><?php echo $project['id']; ?></td>
			<td><?php echo $project['name']; ?></td>
			<td><?php echo $project['a_material']; ?></td>
			<td><?php echo $project['r_material']; ?></td>
			<td><?php echo $project['a_c']; ?></td>
			<td><?php echo $project['r_c']; ?></td>
			<td><?php echo $project['a_m']; ?></td>
			<td><?php echo $project['r_m']; ?></td>
			<td><?php echo $project['a_y']; ?></td>
			<td><?php echo $project['r_y']; ?></td>
			<td><?php echo $project['a_k']; ?></td>
			<td><?php echo $project['r_k']; ?></td>
			<td><?php echo $project['a_pant']; ?></td>
			<td><?php echo $project['r_pant']; ?></td>
			<td><?php echo $project['a_lam']; ?></td>
			<td><?php echo $project['r_lam']; ?></td>
			<td><?php echo $project['mag']; ?></td>
			<td><?php echo $project['cmyk_comment']; ?></td>
			<td><?php echo $project['a_podklad']; ?></td>
			<td><?php echo $project['a_wybr']; ?></td>
			<td><?php echo $project['r_podklad']; ?></td>
			<td><?php echo $project['r_wybr']; ?></td>
			<td><?php echo $project['a_zadruk']; ?></td>
			<td><?php echo $project['r_zadruk']; ?></td>
			<td><?php echo $project['a_podpis']; ?></td>
			<td><?php echo $project['r_podpis']; ?></td>
			<td><?php echo $project['a_zdrapka']; ?></td>
			<td><?php echo $project['r_zdrapka']; ?></td>
			<td><?php echo $project['a_lakpuch']; ?></td>
			<td><?php echo $project['r_lakpuch']; ?></td>
			<td><?php echo $project['a_lakblys']; ?></td>
			<td><?php echo $project['r_lakblys']; ?></td>
			<td><?php echo $project['sito_comment']; ?></td>
			<td><?php echo $project['isperso']; ?></td>
			<td><?php echo $project['perso']; ?></td>
			<td><?php echo $project['dziurka']; ?></td>
			<td><?php echo $project['chip']; ?></td>
			<td><?php echo $project['ksztalt']; ?></td>
			<td><?php echo $project['hologram']; ?></td>
			<td><?php echo $project['option_comment']; ?></td>
			<td><?php echo $project['project_comment']; ?></td>
			<td><?php echo $project['created']; ?></td>
			<td><?php echo $project['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'projects', 'action' => 'view', $project['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'projects', 'action' => 'edit', $project['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'projects', 'action' => 'delete', $project['id']), null, __('Are you sure you want to delete # %s?', $project['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
