<?php
	echo $this->Html->script(array(/*'jquery',*/ 'event'), array('inline' => false)); 
	echo $this->Html->css('job/job-view.css?v=3101181236' //. time()
						 , array('inline' => false));
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
		<dt><?php echo 'id'; ?></dt>
		<dd>
			<?php echo $job['Job']['id']; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Stworzył/a'; ?></dt>
		<dd>
			<?php echo $job['User']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Numer'; ?></dt>
		<dd class="nium">
			<?php echo $this->Ma->bnr2nrj($job['Job']['nr'], null); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Termin'; ?></dt>
		<dd>
			<?php echo $this->Ma->md($job['Job']['stop_day']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Rodzaj arkusza'; ?></dt>
		<dd>
			<?php echo $this->Ma->arkusz[$job['Job']['rodzaj_arkusza']]; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Arkusze netto'; ?></dt>
		<dd>
			<?php echo $this->Ma->tys( $job['Job']['arkusze_netto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Dla laminacji'; ?></dt>
		<dd>
			<?php echo $this->Ma->tys($job['Job']['dla_laminacji']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Zwyżka offset'; ?></dt>
		<dd>
			<?php echo $job['Job']['dla_drukarzy']; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Status'; ?></dt>
		<dd>
			<?php echo $this->Ma->job_stat[$job['Job']['status']]; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Komentarz'; ?></dt>
		<dd>
			<?php echo nl2br($job['Job']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Stworzone'; ?></dt>
		<dd>
			<?php echo $this->Ma->mdt($job['Job']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Zmodyfikowane'; ?></dt>
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
	<table cellpadding = "0" cellspacing = "0" id="lista-kart">
	<tr>
		<th class="id"><?php echo __('Id'); ?></th>
		<th><?php echo __('Nazwa'); ?></th>
		<th class="status"><?php echo 'Status'; ?></th>
		<th class="ile"><?php echo 'Ilość'; ?></th>
		<th class="ikna"><?php echo 'IKNA'; ?></th>
		<th class="opcje">Opcje</th>
		<th class="order"><?php echo 'Zamówienie'; ?></th>
		<!--<th class="opiekun"><?php echo 'Opiekun'; ?></th>-->
	</tr>
	<?php
			$sigma = 0; // sumujemy IKNA
			foreach ($job['Card'] as $card):
	?>
		<tr>
			<td  class="id"><?php echo $card['id']; ?></td>
			<td><?php echo $this->Html->link($card['name'], array(
						'controller' => 'cards', 'action' => 'view', $card['id']
						), array('title' => $card['name'])); ?>
			</td>
			<td class="status"><?php echo $this->Ma->status_karty($card['status']); ?></td>
			<td class="ile"><?php echo $this->Ma->tys($card['quantity']); ?></td>
			<td class="ikna"><?php echo $card['ikna']; ?></td>
			<td class="opcje">
				<?php if( $card['isperso'] ) echo '<span class="perso">P</span>'; ?>
			</td>
			
			<td class="order"><?php 
			
			$nrek = $this->Ma->bnr2nrh($ordery[$card['id']]['Order']['nr'], $ordery[$card['id']]['User']['inic']);
			echo $this->Html->link($nrek, array(
						'controller' => 'orders', 'action' => 'view', $card['order_id']
						), array('escape' => false)); 
			
			
			?></td>
			<!--
			<td class="opiekun"><?php 
				echo $ordery[$card['id']]['User']['name'];?>
			</td>
			-->
			
			
		</tr>
	<?php
		$sigma += $card['ikna'];
		endforeach;
		
	?>
		<!-- Sumowanie IKNA -->
		<tr class="sigma">
			<td  class="id"></td><td></td><td  class="status"></td><td  class="ile"></td>

			<td  class="ikna"><?= $sigma ?></td>
			
			<td  class="opcje"></td><td  class="order"></td>
		</tr>
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

