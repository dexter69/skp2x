<?php
//echo '<pre>';	print_r($this->request->data); echo  '</pre>';
//echo '<pre>';	print_r($cards); echo  '</pre>';
echo $this->Html->css('job', null, array('inline' => false));
echo $this->Html->script(array('job'), array('inline' => false)); 
$this->Ma->displayActions($links);
?>
<div class="jobs form">
<?php 
	echo $this->Form->create('Job'); ?>
	<fieldset>
		<legend><?php echo 'Edytuj Zlecenie ' . 
                        $this->Ma->bnr2nrj($this->request->data['Job']['nr']); 
                ?></legend>
	<?php
		//$this->Ma->ordersInJobX($orders);
		$this->Ma->ordersInJob($cards);
		echo $this->Form->input('id');
		echo $this->Form->hidden('user_id');
		//echo $this->Form->input('offset');
		echo $this->Form->input('stop_day',$vju['stop_day']);
		echo $this->Html->tag('br');
		echo $this->Form->input('rodzaj_arkusza',$vju['rodzaj_arkusza']);
		echo $this->Form->input('arkusze_netto',$vju['arkusze_netto']);
		echo $this->Form->input('dla_laminacji',$vju['dla_laminacji']);
		echo $this->Form->input('dla_drukarzy',$vju['dla_drukarzy']);
		//echo $this->Form->input('forum');
		echo $this->Form->hidden('status',array('default' => 0));
		echo $this->Html->tag('br');
		echo $this->Form->input('comment',$vju['comment']);
	?>
	</fieldset>
<?php echo $this->Form->end('Zapisz'); ?>
</div>

