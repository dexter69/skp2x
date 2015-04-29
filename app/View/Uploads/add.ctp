<?php 

// Wzorzec używany do stworzenia pierwotnego ciągu html, który poszukuje
// javascript przy generowniu pól do wczytanych plików
define('PATT','999');

echo $this->Html->script(array('jquery', 'upload'), array('inline' => false)); 
?>

<div class="uploads form">
<?php echo $this->Form->create('Upload', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Upload'); ?></legend>
	<?php
/*
	Wykorzystujemy metode input do wykreowania potrzebnego kodu hatml a następnie przygotowujemy go
	dla javascriptu i umieszczamy go w thehtml
	UWAGA! istotna jest dana wejściowa '0.role', gdyż skrypty z upload.js tego szuka
*/
		$thehtml = json_encode($this->Form->input(PATT.'.role',$vju['role']).$this->Form->input(PATT.'.roletxt'));
		echo $this->Form->input('files.',$vju['file']);
		echo $this->Html->tag('ul', null, array('id' => 'fileList'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Uploads'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>

<?php $this->Html->scriptStart( array('block' => 'scriptBottom') ); ?>

ufs(<?php echo $thehtml ?>,<?php echo PATT ?>);

<?php $this->Html->scriptEnd(); ?>
