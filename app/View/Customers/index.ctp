<?php

echo $this->Html->css('customer', null, array('inline' => false));
//echo '<pre>'; echo print_r($customers); echo '</pre>';
//echo '<pre>'; echo print_r($links); echo '</pre>';

?>
<div class="customers index">
	<h2><?php echo __('KLIENCI'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			
			<th><?php echo $this->Paginator->sort('name', 'Nazwa'); ?></th>
			
			<th><?php echo 'Adres';//$this->Paginator->sort('osoba_kontaktowa'); ?></th>
			<th><?php echo 'Kraj';//$this->Paginator->sort('tel'); ?></th>
			<th><?php echo $this->Paginator->sort('owner_id', 'Opiekun'); ?></th>
			<th class="ebutt"></th>
	</tr>
	<?php //$time_start = microtime(true);
        foreach ($customers as $customer): ?>
	<tr>
		<td><?php echo $customer['Customer']['id']; ?>&nbsp;</td>
		
		<td>
			<?php 
				echo $this->Html->link($customer['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $customer['Customer']['id'])); 
			//echo h($customer['Customer']['name']); ?>&nbsp;
		</td>		
		<td><?php 
			echo 
					$customer['AdresSiedziby']['ulica'].' '.
					$customer['AdresSiedziby']['nr_budynku'].', '.
					$customer['AdresSiedziby']['miasto']
				; ?>&nbsp;</td>
		<td><?php echo $customer['AdresSiedziby']['kraj']; ?>&nbsp;</td>
		<td><?php echo $customer['Owner']['name']; ?>&nbsp;</td>
		<td class="ebutt"><?php echo $this->Html->link('<div></div>', array('action' => 'edit', $customer['Customer']['id']), array('class' => 'ebutt',  'escape' =>false)); ?></td>
		
	</tr>
<?php endforeach; $time_stop = microtime(true);?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Strona {:page} z {:pages}, wyświetla rekordów: {:current} z wszystkich: {:count}, począwszy od {:start} do {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . 'poprzednia', array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next('następna' . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<?php $this->Ma->displayActions('customers'); 

//echo $time_stop - $time_start;

