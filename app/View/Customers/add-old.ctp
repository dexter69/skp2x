<?php 
// do sekcji head zostanie dodany customer.css
$this->Html->css(array('customer'), null, array('inline' => false));
echo $this->Html->script( array('customer'), array('inline' => false)); 
$code = "var pay = " . json_encode( array( PRZE, CASH ) ) . ";\n" .
		"var defproc = " . json_encode(DEF_ZAL_PROC) . ";\n" .
		"var postpay = " . json_encode( array( PRZE, CASH ) ) . ";\n" .
		"var defterm = " . json_encode(DEF_PAY_TIME) . ";";
echo $this->Html->scriptBlock( $code, array('block' => 'scriptBottom') );
//echo '<pre>'; echo print_r($vju); echo '</pre>';

//print_r($links);
$this->Ma->displayActions($links); 
?>

<div id="klientadd" class="customers form">
<?php echo $this->Form->create('Customer'); ?>
	<fieldset>
		<legend><?php echo 'NOWY KLIENT'; ?></legend>
	<div class="wrapit">

	<?php
		echo $this->Form->input('name',$vju['name']);
		echo $this->Form->hidden('owner_id',$vju['owner_id']);
		//echo $this->Html->tag('hr');
		echo $this->Form->input('AdresSiedziby.name',$vju['fullname']);
		
		$markup =	$this->Form->input('AdresSiedziby.ulica',$vju['ulica']) .
					$this->Form->input('AdresSiedziby.nr_budynku',$vju['nr_budynku']);
		
		$this->Ma->responsive_divs( $markup, 'ulica_nr');
		
		$markup =	$this->Form->input('AdresSiedziby.kod',$vju['kod'])	.
					$this->Form->input('AdresSiedziby.miasto',$vju['miasto']) .
					$this->Form->input('AdresSiedziby.kraj',$vju['kraj']);
		
		$this->Ma->responsive_divs( $markup, 'kod_mia_kra');
		
		echo $this->Form->hidden('vatno',$vju['vatno']);
		
		$markup =	$this->Form->input('vatno_txt',$vju['vatno_txt']) .
					$this->Form->input('waluta',$vju['waluta']) .
                    $this->Form->input('etylang', $vju['etylang']) .
					$this->Form->input('cr',$vju['cr']);
		$this->Ma->responsive_divs( $markup, 'vat_wal_cr');
					
		
		$markup =	$this->Form->input('osoba_kontaktowa',$vju['osoba_kontaktowa']) .
					$this->Form->input('email',$vju['email']) .
					$this->Form->input('tel',$vju['tel']);					;
		$this->Ma->responsive_divs( $markup, 'osob_kontakt');					
		
		//echo $this->Html->tag('hr');
			
		//echo '</div>';
		//echo '<br/>';
		//echo $this->Html->div('contact_person');
		
		$markup1 =	$this->Form->input('forma_zaliczki', $vju['forma_zaliczki']) .
					$this->Form->input('procent_zaliczki', $vju['procent_zaliczki']);
		$markup2 =	$this->Form->input('forma_platnosci', $vju['forma_platnosci']) .
					$this->Form->input('termin_platnosci', $vju['termin_platnosci']);
					
		
		$markup =	$this->Html->div('opcje_platnosci') .
						$this->Ma->responsive_divs2( $markup1, 'forma_zal') .
						$this->Ma->responsive_divs2( $markup2, 'forma_plat') .
					$this->Html->tag('/div') .
					$this->Form->input('comment',$vju['comment']);
					
		echo $this->Ma->responsive_divs2( $markup, 'plat_comment');
		echo $this->Form->hidden('prc');
		echo $this->Form->hidden('term');		
	?>
	</div>
	</fieldset>
<?php echo $this->Form->end(__('Zapisz')); ?>
</div>



<!--
<div class="actions">
	
	<ul>

		<li><?php echo $this->Html->link(__('Lista Klientów'), array('action' => 'index')); ?></li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Nowa Karta'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Kart'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Nowe Zamówienie'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Zamówień'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
-->