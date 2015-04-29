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
			
			<!--<th><?php echo $this->Paginator->sort('fullname'); ?></th>
			<th><?php echo $this->Paginator->sort('ulica'); ?></th>
			<th><?php echo $this->Paginator->sort('nr_budynku'); ?></th>
			<th><?php echo $this->Paginator->sort('miasto'); ?></th>
			<th><?php echo $this->Paginator->sort('kod'); ?></th>
			<th><?php echo $this->Paginator->sort('kraj'); ?></th>
			--><th><?php echo 'Adres';//$this->Paginator->sort('osoba_kontaktowa'); ?></th>
			<th><?php echo 'Kraj';//$this->Paginator->sort('tel'); ?></th>
			<th><?php echo $this->Paginator->sort('owner_id', 'Opiekun'); ?></th>
			<th class="ebutt"></th><!--
			<th><?php echo $this->Paginator->sort('vatno'); ?></th>
			<th><?php echo $this->Paginator->sort('vatno_txt'); ?></th>
			<th><?php echo $this->Paginator->sort('waluta'); ?></th>
			<th><?php echo $this->Paginator->sort('forma_zaliczki'); ?></th>
			<th><?php echo $this->Paginator->sort('procent_zaliczki'); ?></th>
			<th><?php echo $this->Paginator->sort('forma_platnosci'); ?></th>
			<th><?php echo $this->Paginator->sort('termin_platnosci'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>-->
	</tr>
	<?php $time_start = microtime(true);
        foreach ($customers as $customer): ?>
	<tr>
		<td><?php echo $customer['Customer']['id']; ?>&nbsp;</td>
		
		<!--
		<td><?php echo h($customer['Customer']['name']); ?>&nbsp;</td>-->
		<td>
			<?php 
				echo $this->Html->link($customer['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $customer['Customer']['id'])); 
			//echo h($customer['Customer']['name']); ?>&nbsp;
		</td>
		
		
		
		<!--<td><?php echo h($customer['Customer']['fullname']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['ulica']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['nr_budynku']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['miasto']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['kod']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['kraj']); ?>&nbsp;</td>
		--><td><?php 
			echo h(
					$customer['AdresSiedziby']['ulica'].' '.
					$customer['AdresSiedziby']['nr_budynku'].', '.
					$customer['AdresSiedziby']['miasto']
				); ?>&nbsp;</td>
		<td><?php echo h($customer['AdresSiedziby']['kraj']); ?>&nbsp;</td>
		<td><?php echo h($customer['Owner']['name']); ?>&nbsp;</td>
		<td class="ebutt"><?php echo $this->Html->link('<div></div>', array('action' => 'edit', $customer['Customer']['id']), array('class' => 'ebutt',  'escape' =>false)); ?></td><!--
		<td><?php echo h($customer['Customer']['vatno']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['vatno_txt']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['waluta']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['forma_zaliczki']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['procent_zaliczki']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['forma_platnosci']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['termin_platnosci']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['created']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['modified']); ?>&nbsp;</td>-->
		<!--
		
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $customer['Customer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $customer['Customer']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $customer['Customer']['id']), null, __('Are you sure you want to delete # %s?', $customer['Customer']['id'])); ?>
		</td>-->
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
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<?php $this->Ma->displayActions('customers'); 

echo $time_stop - $time_start;

