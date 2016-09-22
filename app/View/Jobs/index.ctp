<?php 
//echo '<pre>'; print_r($jobs); echo '</pre>';
echo $this->Html->css('job',  null, array('inline' => false));
$this->Ma->displayActions('jobs'); 
$this->set('title_for_layout', 'Produkcyjne');

$klasa = array(	'all-but-priv'=>null, 'my'=>null, 'active'=>null, 'closed'=>null, 'started'=>null);
if( array_key_exists($par, $klasa) )
	$klasa[$par] = 'swieci';

?>

<div class="jobs index">
	<h2 class="indexnag"><?php echo 'PRODUKCYJNE' . $this->Ma->indexFiltry('jobs', $klasa);; ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			
			<th><?php echo $this->Paginator->sort('nr', 'Numer'); ?></th>
			<th><?php echo $this->Paginator->sort('stop_day', 'Termin'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id','Kto'); ?></th>
			
			
			<th><?php echo $this->Paginator->sort('rodzaj_arkusza'); ?></th>
			<th><?php echo $this->Paginator->sort('arkusze_netto'); ?></th><!--
			<th><?php echo $this->Paginator->sort('dla_laminacji'); ?></th>
			<th><?php echo $this->Paginator->sort('dla_drukarzy'); ?></th>
			<th><?php echo $this->Paginator->sort('forum'); ?></th>-->
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="ebutt"></th><!--
			<th><?php echo $this->Paginator->sort('comment'); ?></th>-->
			<!--<th><?php echo $this->Paginator->sort('created', 'Utworzone'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>-->
	</tr>
	<?php foreach ($jobs as $job): ?>
	<tr>
		<!--<td><?php echo h($job['Job']['id']); ?>&nbsp;</td>-->
		<td>
			<?php echo $this->Html->link($job['Job']['id'], array('action' => 'view', $job['Job']['id'])); ?>&nbsp;
		</td>
		
		<td><?php echo $this->Html->link(
						$this->Ma->bnr2nrj($job['Job']['nr'], null),
						array('action' => 'view', $job['Job']['id']), array('escape' => false));
		
		 ?>&nbsp;</td>
		<td><?php echo $this->Ma->md($job['Job']['stop_day']); ?>&nbsp;</td>
		<td>
			<?php //echo $this->Html->link($job['User']['name'], array('controller' => 'users', 'action' => 'view', $job['User']['id'])); 
					echo $job['User']['name'];
			?>
		</td>
		
		
		<td><?php echo $this->Ma->arkusz[$job['Job']['rodzaj_arkusza']]; ?>&nbsp;</td>
		<td><?php echo $this->Ma->tys( $job['Job']['arkusze_netto'] ); ?>&nbsp;</td><!--
		<td><?php echo h($job['Job']['dla_laminacji']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['dla_drukarzy']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['forum']); ?>&nbsp;</td>-->
		<td><?php echo $this->Ma->job_stat[$job['Job']['status']]; ?>&nbsp;</td>
		<td class="ebutt"><?php echo $this->Html->link('<div></div>', array('action' => 'edit', $job['Job']['id']), array('class' => 'ebutt',  'escape' =>false)); ?></td><!--
		<td><?php echo h($job['Job']['comment']); ?>&nbsp;</td>-->
		<!--<td><?php echo $this->Ma->mdt($job['Job']['created']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['modified']); ?>&nbsp;</td>-->
		<!--	
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $job['Job']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $job['Job']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $job['Job']['id']), null, __('Are you sure you want to delete # %s?', $job['Job']['id'])); ?>
		</td>-->
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
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
<?php
$this->App->print_r2($jobs);