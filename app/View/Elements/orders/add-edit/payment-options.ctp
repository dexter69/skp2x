<?php

$markup =
			$this->Html->tag('div') .
			$this->Form->input('forma_zaliczki',$vju['forma_zaliczki']) .
			$this->Form->input('forma_platnosci',$vju['forma_platnosci']) .
			$this->Html->tag('/div') .
			$this->Html->tag('div') .
				$this->Form->input('procent_zaliczki',$vju['procent_zaliczki']) .
			 	$this->Form->input('termin_platnosci',$vju['termin_platnosci']) .
			$this->Html->tag('/div');
				
		$markup = 
			$this->Html->tag('div', null, array('id' => 'paywrap')) .
				$this->Ma->viewheader('OPCJE PŁATNOŚCI', array( 'id' => 'p_pay', 'class' => 'margin03')) .
				$this->Ma->responsive_divs2( $markup, 'platnosci') .					
			$this->Html->tag('/div');

?>