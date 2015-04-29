<?php 

// Wzorzec używany do stworzenia pierwotnego ciągu html, który poszukuje
// javascript przy generowniu pól do wczytanych plików
define('PATT','999');

// do sekcji head zostanie dodany project.css
$this->Html->css('project', null, array('inline' => false));
echo $this->Html->script(array('jquery', 'project'), array('inline' => false)); 

echo '<pre>';	print_r($pliki); echo  '</pre>';
echo '<pre>';	print_r($uploads); echo  '</pre>';
echo '<pre>';	print_r($karty); echo  '</pre>';
		 

?>
<div class="projects form">
<?php echo $this->Form->create('Project', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Project'); ?></legend>
	<?php
		//echo $this->Form->input('Project.name');
		echo $this->Form->input('Card.name',$vju['name']); 
		
		echo $this->Form->input('Card.customer_id'); echo '<br/>';
		echo $this->Form->input('Upload.files.',$vju['file']);
		echo $this->Html->tag('ul', '', array('id' => 'fileList'));
		
		echo '<br/>';
		echo $this->Form->input('Upload');echo '<br/>';
		echo $this->Form->input('Project.a_material',$vju['x_material']);
		echo $this->Form->input('Project.r_material',$vju['x_material']);echo '<br/>';
		echo $this->Form->input('Project.a_c',$vju['x_c']);
		echo $this->Form->input('Project.a_m',$vju['x_m']);
		echo $this->Form->input('Project.a_y',$vju['x_y']);
		echo $this->Form->input('Project.a_k',$vju['x_k']);echo '<br/>';
		echo $this->Form->input('Project.r_c',$vju['x_c']);
		echo $this->Form->input('Project.r_m',$vju['x_m']);
		echo $this->Form->input('Project.r_y',$vju['x_y']);
		echo $this->Form->input('Project.r_k',$vju['x_k']);echo '<br/>';
		echo $this->Form->input('Project.a_pant',$vju['x_pant']);
		echo $this->Form->input('Project.r_pant',$vju['x_pant']);echo '<br/>';
		echo $this->Form->input('Project.a_lam',$vju['x_lam']);
		echo $this->Form->input('Project.r_lam',$vju['x_lam']);echo '<br/>';
		echo $this->Form->input('Project.mag',$vju['mag']);
		echo $this->Form->input('Project.cmyk_comment');echo '<br/>';
		
		echo $this->Form->input('Project.a_podklad',$vju['x_sito']);
		echo $this->Form->input('Project.a_wybr',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('Project.r_podklad',$vju['x_sito']);
		echo $this->Form->input('Project.r_wybr',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('Project.a_zadruk',$vju['x_sito']);
		echo $this->Form->input('Project.r_zadruk',$vju['x_sito']);echo '<br/>';
		echo $this->Form->input('Project.a_podpis',$vju['x_podpis']);
		echo $this->Form->input('Project.r_podpis',$vju['x_podpis']);echo '<br/>';
		echo $this->Form->input('Project.a_zdrapka',$vju['yesno']);
		echo $this->Form->input('Project.r_zdrapka',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('Project.a_lakpuch',$vju['yesno']);
		echo $this->Form->input('Project.r_lakpuch',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('Project.a_lakblys',$vju['yesno']);
		echo $this->Form->input('Project.r_lakblys',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('Project.sito_comment');echo '<br/>';
		echo $this->Form->input('Project.isperso');
		echo $this->Form->input('Project.perso');echo '<br/>';
		echo $this->Form->input('Project.dziurka',$vju['dziurka']);
		echo $this->Form->input('Project.chip',$vju['chip']);
		echo $this->Form->input('Project.ksztalt',$vju['ksztalt']);
		echo $this->Form->input('Project.hologram',$vju['yesno']);
		echo $this->Form->input('Project.option_comment');echo '<br/>';
		echo $this->Form->input('Project.project_comment');echo '<br/>';
		
/*
	Wykorzystujemy metode input do wykreowania potrzebnego kodu hatml a następnie przygotowujemy go
	dla javascriptu i umieszczamy go w thehtml
	UWAGA! istotna jest dana wejściowa '0.role', gdyż skrypty z upload.js tego szuka
*/
		$thehtml = json_encode($this->Form->input('Upload.'.PATT.'.role',$vju['role']).$this->Form->input('Upload.'.PATT.'.roletxt'));
		
		echo '<br/>';
		//echo $this->Form->input('Upload.filename',array('default' => 'x'));

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Projects'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cards'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Uploads'), array('controller' => 'uploads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
	</ul>
</div>

<?php $this->Html->scriptStart( array('block' => 'scriptBottom') ); ?>

ufs(<?php echo $thehtml ?>,<?php echo PATT ?>);

<?php $this->Html->scriptEnd(); ?>

