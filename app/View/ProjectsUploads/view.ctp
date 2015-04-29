<div class="projectsUploads view">
<h2><?php echo __('Projects Upload'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($projectsUpload['ProjectsUpload']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Project'); ?></dt>
		<dd>
			<?php echo $this->Html->link($projectsUpload['Project']['name'], array('controller' => 'projects', 'action' => 'view', $projectsUpload['Project']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Upload'); ?></dt>
		<dd>
			<?php echo $this->Html->link($projectsUpload['Upload']['title'], array('controller' => 'uploads', 'action' => 'view', $projectsUpload['Upload']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Projects Upload'), array('action' => 'edit', $projectsUpload['ProjectsUpload']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Projects Upload'), array('action' => 'delete', $projectsUpload['ProjectsUpload']['id']), null, __('Are you sure you want to delete # %s?', $projectsUpload['ProjectsUpload']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects Uploads'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Projects Upload'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Uploads'), array('controller' => 'uploads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
	</ul>
</div>
