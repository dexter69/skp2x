<?php 
// do sekcji head zostanie dodany customer.css
$this->Html->css(array(/**/'customer'), null, array('inline' => false));
echo $this->Html->script( array('jquery', /* 'common',*/ 'customer'), array('inline' => false)); 

$code = "var pay = " . json_encode( array( PRZE, CASH ) ) . ";\n" .
		"var defproc = " . json_encode(DEF_ZAL_PROC) . ";\n" .
		"var postpay = " . json_encode( array( PRZE, CASH ) ) . ";\n" .
		"var defterm = " . json_encode(DEF_PAY_TIME) . ";";		
		
echo $this->Html->scriptBlock( $code, array('block' => 'scriptBottom') );

//echo '<pre>'; echo print_r($vju); echo '</pre>';
//echo '<pre>'; print_r($links); echo '</pre>';
//echo '<pre>'; echo print_r($this->request->data); echo '</pre>';

$this->Ma->displayActions($links); 

?>

<div id="klientadit" class="customers form">
<?php echo $this->Form->create('Customer'); ?>
<?php $this->Ma->nawiguj( $links, $this->request->data['Customer']['id'] ); //nawigacyjne do dodaj, usuń, edycja itp. ?>
	<fieldset>
		<legend><?php echo 'EDYCJA:<span>' . $this->request->data['Customer']['name'] .'</span>' ; ?></legend>
	<div class="wrapit">

	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->input('name',$vju['name']);
		echo $this->Form->hidden('owner_id',$vju['owner_id']);
		
		echo $this->Form->hidden('AdresSiedziby.id');
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
					$this->Form->input('cr',$vju['cr']);
		$this->Ma->responsive_divs( $markup, 'vat_wal_cr');
					
		
		$markup =	$this->Form->input('osoba_kontaktowa',$vju['osoba_kontaktowa']) .
					$this->Form->input('email',$vju['email']) .
					$this->Form->input('tel',$vju['tel']);					;
		$this->Ma->responsive_divs( $markup, 'osob_kontakt');					
		
		
		
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

