<?php
	echo $this->Html->script(array(/*'jquery',*/ 'event'), array('inline' => false)); 
	//echo '<pre>';	print_r($submits); echo  '</pre>';	
	//echo '<pre>';	print_r($ordery); echo  '</pre>';
	//echo '<pre>';	print_r($ludz); echo  '</pre>';
	//echo '<pre>';	print_r($npug); echo  '</pre>';
        
        //echo '<pre>';	print_r($job); echo  '</pre>';
        
        
        //if( AuthComponent::user('id') == 1 ) { }
        
	$this->Ma->displayActions($links);
        
        /**/
        if( $job['Job']['nr'] ) {
            $this->set('title_for_layout', $this->Ma->bnr2nrj( $job['Job']['nr'], null, false));
        } else {
            $this->set('title_for_layout', 'Zlecenie Produkcyjne');
        }
?>
<div class="jobs view">
<h2 class="oj-naglowek"><?php
		echo '<strong>'. $this->Ma->bnr2nrj($job['Job']['nr'], null, false) . '</strong>'.
		$this->Ma->editlink('job',$job['Job']['id']).
                $this->Ma->pdflink('job', $job['Job']['id']) 
		;
		
		 ?>
			
</h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($job['Job']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Stworzył/a'); ?></dt>
		<dd>
			<?php echo $job['User']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numer'); ?></dt>
		<dd class="nium">
			<?php echo $this->Ma->bnr2nrj($job['Job']['nr'], null); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Termin'); ?></dt>
		<dd>
			<?php echo $this->Ma->md($job['Job']['stop_day']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rodzaj arkusza'); ?></dt>
		<dd>
			<?php echo $this->Ma->arkusz[$job['Job']['rodzaj_arkusza']]; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Arkusze netto'); ?></dt>
		<dd>
			<?php echo $this->Ma->tys( $job['Job']['arkusze_netto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dla laminacji'); ?></dt>
		<dd>
			<?php echo $this->Ma->tys($job['Job']['dla_laminacji']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zwyżka offset'); ?></dt>
		<dd>
			<?php echo h($job['Job']['dla_drukarzy']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo $this->Ma->job_stat[$job['Job']['status']]; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Komentarz'; ?></dt>
		<dd>
			<?php echo nl2br($job['Job']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Stworzone'); ?></dt>
		<dd>
			<?php echo $this->Ma->mdt($job['Job']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zmodyfikowane'); ?></dt>
		<dd>
			<?php echo $this->Ma->mdt($job['Job']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
	
	

	
	
</div>



<div class="related">
	<!--
	<h3>
	-->
	<?php echo $this->Ma->viewheader('KARTY', array('class' => 'margin02') ); ?>
	<!--	
	</h3>
	-->
	<?php if (!empty($job['Card'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nazwa'); ?></th>
		<th><?php echo 'Status'; ?></th>
		<th><?php echo __('Ilość'); ?></th>
		<th><?php echo __('IKNA'); ?></th>
		<th>Opcje</th>
		<th><?php echo __('Zamówienie'); ?></th>
		<th><?php echo __('Opiekun'); ?></th>
		<!--<th><?php echo __('Klient'); ?></th>-->
		
		
		<!--<th><?php echo __('Job Id'); ?></th>-->
		<!--
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Wzor'); ?></th>
		<th><?php echo __('Comment'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>-->
	</tr>
	<?php foreach ($job['Card'] as $card): ?>
		<tr>
			<td><?php echo $card['id']; ?></td>
			<td><?php echo $this->Html->link($card['name'], array(
						'controller' => 'cards', 'action' => 'view', $card['id']
						), array('title' => $card['name'])); ?>
			</td>
			<td><?php echo $this->Ma->status_karty($card['status']); ?></td>
			<td><?php echo $this->Ma->tys($card['quantity']); ?></td>
			<td><?php echo $card['ikna']; ?></td>
			<td>
				<?php if( $card['isperso'] ) echo '<span class="perso">P</span>'; ?>
			</td>
			
			<!--<td><?php echo $card['customer_id']; ?></td>-->
			<!--
			<td><?php
				//echo $ordery[$card['id']]['Customer']['name'];
				echo $this->Html->link($ordery[$card['id']]['Customer']['name'], array(
						'controller' => 'customers', 'action' => 'view', $card['customer_id']
						));
			 ?>
				
			</td>-->
			
			<!--<td><?php echo $card['order_id']; ?></td>-->
			<td><?php 
			
			$nrek = $this->Ma->bnr2nrh($ordery[$card['id']]['Order']['nr'], $ordery[$card['id']]['User']['inic']);
			echo $this->Html->link($nrek, array(
						'controller' => 'orders', 'action' => 'view', $card['order_id']
						), array('escape' => false)); 
			
			//echo $this->Html->link($this->Ma->bnr2nrh($order['Order']['nr'], $order['User']['inic']), array('action' => 'view', $order['Order']['id']), array('escape' => false));
			?></td>
			<td><?php 
			echo $ordery[$card['id']]['User']['name'];
			//echo $job['User']['name']; ?></td>
			<!--<td><?php echo $card['job_id']; ?></td>-->
			
			<!--
			<td><?php echo $card['price']; ?></td>
			<td><?php echo $card['wzor']; ?></td>
			<td><?php echo $card['comment']; ?></td>
			<td><?php echo $card['status']; ?></td>
			<td><?php echo $card['created']; ?></td>
			<td><?php echo $card['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'cards', 'action' => 'view', $card['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'cards', 'action' => 'edit', $card['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'cards', 'action' => 'delete', $card['id']), null, __('Are you sure you want to delete # %s?', $card['id'])); ?>
			</td>-->
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
	<!--
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		</ul>
	</div>-->
</div>

<div class="ul-events">
	<?php $this->Ma->kontrolka_job($job, $submits);	?>
	<ul>
		<?php
			// ustalamy kierunek wyświetlania postów
			if( $npug ) { // 'najnowszy post u góry'
				$start = count($job['Event'])-1; $stop = -1; $step = -1;
			} else { $start = 0; $stop = count($job['Event']); $step = 1; }
			
    		for ($i = $start; $i != $stop; $i=$i+$step) {
    			
    			$event = $job['Event'][$i];
				echo $this->Html->tag('li', null, array('class' => 'post'));
					echo $this->Html->tag('div', null, array('class' => 'postinfo'));
					if( $event['card_id'] ) $co = '<span>kartę: </span>'.$karty[$event['card_id']]; 
					else
						$co ='';
					/*	if( $event['co'] == ORDKOM ) 
							$co ='';
						else
							$co ='<span>zlecenie</span>';*/
					//substr($event['created'],0,10)
					echo '<p>'.$ludz[$event['user_id']]['name'].'</p>'.'<p class="gibon"><span class="'.$this->Ma->evtext[$event['co']]['class'].'">'.$this->Ma->evtext[$event['co']][$ludz[$event['user_id']]['k']].'</span></p>'.'<span>'.$this->Ma->mdt($event['created']).'</span>';
					$list = array( nl2br($event['post']) );
					
					echo $this->Html->tag('/div');
					
					echo $this->Html->tag('div');
						echo $this->Html->nestedList(
						$list,
						array('class'=>'olevent'),
						null,
						'ol'
						);
					echo $this->Html->tag('span', $i+1, array('class' => 'event_nr'));	
					if( (	$event['co'] == eJ_FILE1 ||
							$event['co'] == eJ_FILE2 ||
							$event['co'] == eJ_FILE3 ||
							$event['co'] == eJ_DBACK)&&
							!empty($job['Upload']) ) { //do posta są załączone pliki
						$out = null;
						foreach( $job['Upload'] as $plik ) {
							if( $plik['event_id'] == $event['id'] ) { //
								$link = $this->Html->link($plik['filename'],
										array('controller' => 'uploads', 'action' => 'download', $plik['id'])
								);
								$out = $out.$this->Html->tag('p', $link, array('class' => 'evplik'));
							}
						}
						if( $out ) {
							echo $this->Html->tag('hr');
							echo $out;
						}
						
					}
					
					echo $this->Html->tag('/div');
					
				echo $this->Html->tag('/li');
			}
			//endforeach; 
			?>	
	</ul>
</div>

<!--

<div class="related">
	<h3><?php echo __('Related Events'); ?></h3>
	<?php if (!empty($job['Event'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Order Id'); ?></th>
		<th><?php echo __('Job Id'); ?></th>
		<th><?php echo __('Card Id'); ?></th>
		<th><?php echo __('Co'); ?></th>
		<th><?php echo __('Post'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($job['Event'] as $event): ?>
		<tr>
			<td><?php echo $event['id']; ?></td>
			<td><?php echo $event['user_id']; ?></td>
			<td><?php echo $event['order_id']; ?></td>
			<td><?php echo $event['job_id']; ?></td>
			<td><?php echo $event['card_id']; ?></td>
			<td><?php echo $event['co']; ?></td>
			<td><?php echo $event['post']; ?></td>
			<td><?php echo $event['created']; ?></td>
			<td><?php echo $event['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'events', 'action' => 'view', $event['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'events', 'action' => 'edit', $event['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'events', 'action' => 'delete', $event['id']), null, __('Are you sure you want to delete # %s?', $event['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
-->