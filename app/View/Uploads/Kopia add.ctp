<?php echo $this->Html->script('jquery', array('inline' => false)); ?>
<div class="uploads form">
<?php echo $this->Form->create('Upload', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Upload'); ?></legend>
	<?php
		/*echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('filename',$vju['upl']);
		echo $this->Form->input('filesize',$vju['upl']);
		echo $this->Form->input('filemime',$vju['upl']);
		echo $this->Form->input('uuidname',$vju['upl']);*/
		
		$gibon = $this->Form->input('role',$vju['role']);
		//echo $this->Form->input('file', array('type' => 'file'));
		echo $this->Form->input('files.',$vju['file']);
		echo $this->Html->tag('ul', null, array('id' => 'fileList'));

		//echo $this->Form->input('1.role',$vju['role']);
		//echo $this->Form->input('1.file', array('type' => 'file'));
		//echo $this->Form->input('file1', array('type' => 'file'));
		//echo $this->Form->input('Project');
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
<?php

$this->Html->scriptStart( array('block' => 'scriptBottom') );
?>

$('#UploadFiles').change(function() {

	var myvar = <?php echo json_encode($gibon); ?>;

    var $fileList = $("#fileList");
    $fileList.empty();

    for (var i = 0; i < this.files.length; i++) {
		
        var file = this.files[i];
        $fileList.append('<li>' + file.name + myvar + '</li>');
		
    }
});
<?php

$this->Html->scriptEnd();
//$a = 'foo';
//echo $this->Html->script('upload', array('block' => 'scriptBottom'));
//echo $this->Html->script('test');
//echo $this->Html->scriptBlock( 'stuff', array('block' => 'scriptBottom') ); 

?>
