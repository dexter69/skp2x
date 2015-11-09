<div class="proofs view">
<h2><?php echo __('Proof'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Card'); ?></dt>
		<dd>
			<?php echo $this->Html->link($proof['Card']['name'], array('controller' => 'cards', 'action' => 'view', $proof['Card']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Eng'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['eng']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cr'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['cr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Waluta'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['waluta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('A Kolor'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['a_kolor']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('R Kolor'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['r_kolor']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Size'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uwagi'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['uwagi']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($proof['Proof']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Proof'), array('action' => 'edit', $proof['Proof']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Proof'), array('action' => 'delete', $proof['Proof']['id']), array(), __('Are you sure you want to delete # %s?', $proof['Proof']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Proofs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Proof'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cards'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
	</ul>
</div>
