<?php 
// do sekcji head zostanie dodany customer.css
//jquery-ui-1.10.4.custom.min

$tedane = $this->request->data;

echo $this->Html->css(array('order', 'sunny/jquery-ui-1.10.4.custom.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery', 'jquery-ui', 'jquery.ui.datepicker-pl'/*, 'common'*/), array('inline' => false)); 
$code = //"var platnosci = " . json_encode($tedane['platnosci']) . ";\n" .
		"var pay = " . json_encode( array( PRZE, CASH ) ) . ";\n" .
		"var defproc = " . json_encode(DEF_ZAL_PROC) . ";\n" .
		//"var adres = " . json_encode($tedane['AdresDoFaktury'], JSON_UNESCAPED_UNICODE) . ";\n" .
		"var adres = " . $this->Ma->mjson($tedane['AdresDoFaktury']) . ";\n" .
		"var czas_realiz = " . ORD_TIME . ";\n" .
		"var stop_day = " . json_encode( substr($tedane['Order']['stop_day'], 2) ) . ";\n" .
		"var od = " . json_encode( array( (string)NAF, (string)IA ) ) . ";";
		
if( $tedane['Order']['siedziba_id'] != $tedane['Order']['wysylka_id'] && array_key_exists('AdresDostawy', $tedane) )
	//$code .= "\nvar wysylka = " . json_encode($tedane['AdresDostawy'], JSON_UNESCAPED_UNICODE) . ";";
	$code .= "\nvar wysylka = " . $this->Ma->mjson($tedane['AdresDostawy']) . ";";
else
	$code .= "\nvar wysylka = null;";


		
echo $this->Html->scriptBlock($code, array('block' => 'scriptBottom'));
echo $this->Html->script( 'order-edit', array('block' => 'scriptBottom')); 

//echo '<pre>'; print_r($tedane); echo '</pre>';

//if( $platnosci == $platnosci2 ) echo 'TO SAMO';
$this->Ma->displayActions($links);


?>

<div class="orders form">
<?php  
		//$this->Ma->nawiguj( $links );
		echo $this->Form->create('Order');
?>
	<fieldset>
		<legend><?php echo 'EDYCJA ZAMÓWIENIA (H)'; ?></legend>
	<?php
		
		echo $this->Form->hidden('id');
		echo $this->Form->input('customer_id', array('type' => 'hidden', 'default' => 0));
		echo $this->Form->input('siedziba_id', array('type' => 'hidden', 'default' => 0));


		// KARTY
		$i=0;	$tablica =  array();
		foreach ($tedane['Card'] as $karta) {
			
			if( $karta['price'] == null ) 
				$this->request->data['Card'][$i]['price'] = '';
			else
				$this->request->data['Card'][$i]['price'] = $this->Ma->colon($karta['price']);
			if( $karta['order_id'] == 0 ) 
				$checkbool = $reqbool = false;
			else 
				$checkbool = $reqbool = true;
			
			$card_id = $this->Form->input('Card.'.$i.'.id',array('default' => $karta['id']));
			$order_id = $this->Form->input('Card.'.$i.'.order_id',array('default' => $karta['order_id'], 'type' => 'hidden'));
			
			$checkbox = $this->Form->input('Card.'.$i.'.checked',array(
						'type' => 'checkbox',
						'label' => false,
						'div' => false,
						'class' => 'ci'.$tedane['Customer']['id'],
						'customer_id' => $tedane['Customer']['id'],
						'row' => $i,
						//'required' => 'required'
						'checked'  => $checkbool
				));
			
			$select = 	array($card_id.$order_id.$checkbox, array('class' => 'noinput'));
			
			$nazwakarty = array(
				$this->Html->link($karta['name'], array('controller' => 'cards', 'action' => 'view', $karta['id'])),
				array('class' => 'nazwakar')
			);
				
			$vju['ilosc']['disabled'] = true;
			$ilosc = array(  
					$this->Form->input('Card.'.$i.'.ilosc',$vju['ilosc']),
					array('row' => $i, 'class' => 'ile')
			);
			$mnoznik = array(  
					$this->Form->input('Card.'.$i.'.mnoznik',$vju['mnoznik']),
					array('class' => 'mnoznik')
			);
			$vju['price']['disabled'] = true;
			
			$cena = array( 
					$this->Form->input('Card.'.$i.'.price',$vju['price']),
					array('row' => $i++, 'class' => 'cena')
			);
			$klient = $this->Html->link($tedane['Customer']['name'] ,
    		    		array('controller' => 'customers', 'action' => 'view', $tedane['Customer']['id']));
			

			
						
			$tablica[] = array(
				$select,
				$nazwakarty,
				$ilosc,
				$mnoznik,
				$cena,
				$klient
			);
		}
		
		//echo '<pre>'; print_r($tablica); echo '</pre>';
		echo $this->Html->div('view_wrap', null, array('id' => 'kart_wrap'));
		
			echo $this->Ma->viewheader('KARTY', array('class' => 'margin03') );
			echo $this->Html->tag('table',null, array('id' => 'ordcards'));
		
			echo $this->Html->tableHeaders(array(
				'',
				array( 'Nazwa karty' => array('class' => 'nazwakar') ),
				array('Ilość kart' => array('class' => 'cenaile ile')),
				array('Mnożnik' => array('class' => 'mnoznik')),
				array('Cena' => array('class' => 'cenaile cena')),
				'Klient'
			));
			echo $this->Html->tableCells($tablica);
			echo $this->Html->tag('/table');
		
		echo $this->Html->tag('/div');
		
		
		
		

		//OPCJE PŁATNOŚCI
		
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
					$this->Html->tag('div') .
						$this->Form->input('newcustomer', $vju['newcustomer']) .
					$this->Html->tag('/div') .				
				$this->Html->tag('/div');
			
				
			echo $this->Form->hidden('prc');
			echo $this->Form->hidden('trm');
			
		//KALENDARZYK
		$markup =
			$this->Form->hidden('hdate') .
			$this->Html->div('datepickerwrap') .
				$this->Form->hidden('isekspres') .
				$this->Html->div(null, '', array('id' => 'ekspresorder')) .
				$this->Ma->viewheader('DATA ZAKOŃCZENIA', array( 'class' => 'margin03')) .
				$this->Html->div(null, '', array('id' => 'datepicker')) .								
			$this->Html->tag('/div') . $markup;
			
		//echo $markup3;

		echo $this->Ma->responsive_divs2( $markup, 'timeandpay');

		//echo $this->Html->div('view_wrap',null,array('id' => 'extraadres'));
		//echo $this->Html->div('adres_wrap',null );
		echo $this->Html->div('view_wrap', null, array('id' => 'wysylka_wrap'));
			echo $this->Ma->viewheader('OPCJE WYSYŁKI', array( 'class' => 'margin03'));
			
		//echo $this->Html->tag('/div');
			if( array_key_exists('AdresDostawy', $tedane) )
				echo $this->Form->hidden('AdresDostawy.id');
			
			$markup = 
				$this->Form->input('sposob_dostawy', $vju['sposob_dostawy']) .
				$this->Form->input('osoba_kontaktowa', $vju['osoba_kontaktowa']) .
				$this->Form->input('tel',$vju['tel']);	
			echo $this->Ma->responsive_divs2( $markup, 'osokont');
			
			$markup = 
				$this->Form->input('AdresDostawy.name',$vju['nazwa']) .
				$this->Form->input('AdresDostawy.ulica',$vju['ulica']) .
				$this->Form->input('AdresDostawy.nr_budynku',$vju['nr_budynku']);
			echo $this->Ma->responsive_divs2( $markup, 'adres1');
			
			$markup = 			
				$this->Form->input('AdresDostawy.kod',$vju['kod']) .
				$this->Form->input('AdresDostawy.miasto',$vju['miasto']) .
				$this->Form->input('AdresDostawy.kraj',$vju['kraj']);
			echo $this->Ma->responsive_divs2( $markup, 'adres2');
			
		echo $this->Html->tag('/div');
		
		echo $this->Html->div('view_wrap', null, array('id' => 'commentwrap'));
			echo $this->Ma->viewheader('UWAGI', array('class' => 'margin03'));
			echo $this->Form->input('comment', array('label' => false));
		echo $this->Html->tag('/div');
		//echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Zapisz')); ?>
</div>

<?php //echo '<pre>'; print_r($tedane); echo '</pre>'; ?>


