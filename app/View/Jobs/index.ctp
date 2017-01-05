<?php 
//echo '<pre>'; print_r($jobs); echo '</pre>';
echo $this->Html->css('job.css?v=328496968',  null, array('inline' => false));
$this->Ma->displayActions('jobs'); 
$this->set('title_for_layout', 'Produkcyjne');

$klasa = array(	'all-but-priv'=>null, 'my'=>null, 'active'=>null, 'closed'=>null, 'started'=>null);
if( array_key_exists($par, $klasa) ) { $klasa[$par] = 'swieci'; }
?>

<div class="jobs index">
	<h2 class="indexnag"><div><?php echo 'PRODUKCYJNE</div>' . $this->Ma->indexFiltry('jobs', $klasa);; ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			
			<th><?php echo $this->Paginator->sort('nr', 'Numer'); ?></th>
			<th><?php echo $this->Paginator->sort('stop_day', 'Termin'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id','Kto'); ?></th>
			
			
			<th><?php echo $this->Paginator->sort('rodzaj_arkusza'); ?></th>
			<th><?php echo $this->Paginator->sort('arkusze_netto'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="ebutt"></th>			
	</tr>
	<?php foreach ($jobs as $job): 
            if( $job['Job']['isekspres'] ) { $txt = 'class="ekspres"'; } else { $txt = null; }
        ?>
	<tr>
		<td <?php echo $txt; ?>>
			<?php echo $this->Html->link($job['Job']['id'], array('action' => 'view', $job['Job']['id'])); ?>&nbsp;
		</td>
		
		<td ><?php echo $this->Html->link(
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
		<td><?php echo $this->Ma->tys( $job['Job']['arkusze_netto'] ); ?>&nbsp;</td>
		<td><?php echo $this->Ma->job_stat[$job['Job']['status']]; ?>&nbsp;</td>
		<td class="ebutt"><?php echo $this->Html->link('<div></div>', array('action' => 'edit', $job['Job']['id']), array('class' => 'ebutt',  'escape' =>false)); ?></td>		
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
//$this->App->print_r2($jobs);