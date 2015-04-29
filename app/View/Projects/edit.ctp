<div class="projects form">
<?php echo $this->Form->create('Project'); ?>
	<fieldset>
		<legend><?php echo __('Edit Project'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('a_material');
		echo $this->Form->input('r_material');
		echo $this->Form->input('a_c');
		echo $this->Form->input('r_c');
		echo $this->Form->input('a_m');
		echo $this->Form->input('r_m');
		echo $this->Form->input('a_y');
		echo $this->Form->input('r_y');
		echo $this->Form->input('a_k');
		echo $this->Form->input('r_k');
		echo $this->Form->input('a_pant');
		echo $this->Form->input('r_pant');
		echo $this->Form->input('a_lam');
		echo $this->Form->input('r_lam');
		echo $this->Form->input('mag');
		echo $this->Form->input('cmyk_comment');
		echo $this->Form->input('a_podklad');
		echo $this->Form->input('a_wybr');
		echo $this->Form->input('r_podklad');
		echo $this->Form->input('r_wybr');
		echo $this->Form->input('a_zadruk');
		echo $this->Form->input('r_zadruk');
		echo $this->Form->input('a_podpis');
		echo $this->Form->input('r_podpis');
		echo $this->Form->input('a_zdrapka');
		echo $this->Form->input('r_zdrapka');
		echo $this->Form->input('a_lakpuch');
		echo $this->Form->input('r_lakpuch');
		echo $this->Form->input('a_lakblys');
		echo $this->Form->input('r_lakblys');
		echo $this->Form->input('sito_comment');
		echo $this->Form->input('isperso');
		echo $this->Form->input('perso');
		echo $this->Form->input('dziurka');
		echo $this->Form->input('chip');
		echo $this->Form->input('ksztalt');
		echo $this->Form->input('hologram');
		echo $this->Form->input('option_comment');
		echo $this->Form->input('project_comment');
		echo $this->Form->input('Upload');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Project.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Project.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Projects'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cards'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Uploads'), array('controller' => 'uploads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
	</ul>
</div>
