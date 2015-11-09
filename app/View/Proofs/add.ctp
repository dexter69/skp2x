<div class="proofs form">
<?php echo $this->Form->create('Proof'); ?>
	<fieldset>
		<legend><?php echo __('Add Proof'); ?></legend>
	<?php
		echo $this->Form->input('card_id');
		echo $this->Form->input('eng');
		echo $this->Form->input('cr');
		echo $this->Form->input('waluta');
		echo $this->Form->input('a_kolor');
		echo $this->Form->input('r_kolor');
		echo $this->Form->input('size');
		echo $this->Form->input('uwagi');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Proofs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cards'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
	</ul>
</div>
