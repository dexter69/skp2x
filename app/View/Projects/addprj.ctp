<?php 
// do sekcji head zostanie dodany project.css
$this->Html->css('project', null, array('inline' => false));
//echo print_r($vju); echo '<br><br>';
//print_r($vju);
?>
<div class="projects form">
<?php echo $this->Form->create('Project'); ?>
	<fieldset>
		<legend><?php echo __('Add Project'); ?></legend>
	<?php
		echo $this->Form->input('name'); echo '<br/>';
		echo $this->Form->input('a_material',$vju['x_material']);
		echo $this->Form->input('r_material',$vju['x_material']);echo '<br/>';
		echo $this->Form->input('a_c',$vju['x_c']);
		echo $this->Form->input('a_m',$vju['x_m']);
		echo $this->Form->input('a_y',$vju['x_y']);
		echo $this->Form->input('a_k',$vju['x_k']);echo '<br/>';
		echo $this->Form->input('r_c',$vju['x_c']);
		echo $this->Form->input('r_m',$vju['x_m']);
		echo $this->Form->input('r_y',$vju['x_y']);
		echo $this->Form->input('r_k',$vju['x_k']);echo '<br/>';
		echo $this->Form->input('a_pant',$vju['x_pant']);
		echo $this->Form->input('r_pant',$vju['x_pant']);echo '<br/>';
		echo $this->Form->input('a_lam',$vju['x_lam']);
		echo $this->Form->input('r_lam',$vju['x_lam']);echo '<br/>';
		echo $this->Form->input('mag',$vju['mag']);
		echo $this->Form->input('cmyk_comment');echo '<br/>';
		
		echo $this->Form->input('a_podklad',$vju['x_sito']);
		echo $this->Form->input('a_wybr',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('r_podklad',$vju['x_sito']);
		echo $this->Form->input('r_wybr',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('a_zadruk',$vju['x_sito']);
		echo $this->Form->input('r_zadruk',$vju['x_sito']);echo '<br/>';
		echo $this->Form->input('a_podpis',$vju['x_podpis']);
		echo $this->Form->input('r_podpis',$vju['x_podpis']);echo '<br/>';
		echo $this->Form->input('a_zdrapka',$vju['yesno']);
		echo $this->Form->input('r_zdrapka',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('a_lakpuch',$vju['yesno']);
		echo $this->Form->input('r_lakpuch',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('a_lakblys',$vju['yesno']);
		echo $this->Form->input('r_lakblys',$vju['yesno']);echo '<br/>';
		echo $this->Form->input('sito_comment');echo '<br/>';
		echo $this->Form->input('isperso');
		echo $this->Form->input('perso');echo '<br/>';
		echo $this->Form->input('dziurka',$vju['dziurka']);
		echo $this->Form->input('chip',$vju['chip']);
		echo $this->Form->input('ksztalt',$vju['ksztalt']);
		echo $this->Form->input('hologram',$vju['yesno']);
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

		<li><?php echo $this->Html->link(__('List Projects'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cards'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Uploads'), array('controller' => 'uploads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
	</ul>
</div>
