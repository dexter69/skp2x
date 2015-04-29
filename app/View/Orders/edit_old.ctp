<?php 
// do sekcji head zostanie dodany customer.css
echo $this->Html->css('order', null, array('inline' => false));
echo $this->Html->script(array('jquery'), array('inline' => false)); 
//$code = "var platnosci = ". json_encode($tedane['platnosci']) . ";\nvar adresy = " . json_encode($tedane['adresy'], JSON_UNESCAPED_UNICODE);
echo $this->Html->script('order-edit', array('block' => 'scriptBottom')); 
//echo $this->Html->scriptBlock($code, array('block' => 'scriptBottom'));
//echo $this->Html->script('order', array('block' => 'scriptBottom')); 
//echo '<pre>'; print_r($vju); echo '</pre>';
//echo '<pre>'; print_r($karty); echo '</pre>';
//echo '<pre>'; print_r($karty2); echo '</pre>';
//echo '<pre>'; print_r($adresy); echo '</pre>';
//echo '<pre>'; print_r($adresy2); echo '</pre>';
//echo '<pre>'; print_r($platnosci); echo '</pre>';
//echo '<pre>'; print_r($tedane); echo '</pre>';
//echo '<pre>'; print_r($this->request->data); echo '</pre>'; 
//echo '<pre>'; print_r($karty); echo '</pre>';
//echo '<pre>'; print_r($dt); echo '</pre>';

$tedane = $this->request->data;

//if( $platnosci == $platnosci2 ) echo 'TO SAMO';
?>
<div class="orders form">
<?php echo $this->Form->create('Order'); ?>
	<fieldset>
		<legend><?php echo __('Edycja Zamówienia'); ?></legend>
	<?php
		//echo $this->Form->input('user_id');
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('customer_id', array('type' => 'hidden'));
		echo $this->Form->input('siedziba_id', array('type' => 'hidden'));
		
		//echo $this->Form->input('offset');
		echo $this->Form->input('stop_day',$vju['stop_day']);
		echo $this->Html->tag('br');
		echo $this->Form->input('forma_zaliczki',$vju['forma_zaliczki']);
		echo $this->Form->input('procent_zaliczki',$vju['procent_zaliczki']);
		echo $this->Html->tag('br');
		echo $this->Form->input('forma_platnosci',$vju['forma_platnosci']);
		echo $this->Form->input('termin_platnosci',$vju['termin_platnosci']);
		//echo $this->Form->input('Card.mnoznik',$vju['mnoznik']);
		$i=0; //$ti=3; //tab index
		$tablica =  array();
		foreach ($tedane['Card'] as $value) {
			
			
			$card_id = $this->Form->input('Card.'.$i.'.id',array('default' => $value['id']));
			
			$order_id = $this->Form->input('Card.'.$i.'.order_id',array('default' => $value['order_id'], 'type' => 'hidden'));
			
			if( $value['order_id'] == 0 ) 
				$checkbool = $reqbool = false;
			else 
				$checkbool = $reqbool = true;

			$this->request->data['Card'][$i]['price'] = $this->Ma->colon($value['price']);	
			$checkbox = $this->Form->input('Card.'.$i.'.checked',array(
						'type' => 'checkbox',
						'label' => false,
						'div' => false,
						'class' => 'ci'.$value['customer_id'],
						'customer_id' => $value['customer_id'],
						'row' => $i,
						//'required' => ,
						'checked'  => $checkbool
				));
			
			$select = 	array($card_id.$order_id.$checkbox, array('class' => 'noinput'));
			
			$nazwakarty = array($value['name'], array('class' => 'noinput'));
				
			$vju['ilosc']['required'] = $reqbool;
			//$vju['ilosc']['tabindex'] = $ti++;
			$ilosc = array(  
					$this->Form->input('Card.'.$i.'.ilosc',$vju['ilosc']),
					array('row' => $i)
			);
			$mnoznik = array(  
					$this->Form->input('Card.'.$i.'.mnoznik',$vju['mnoznik']),
					array('class' => 'mnoznik')
			);
			$vju['price']['required'] = $reqbool;
			//$vju['price']['tabindex'] = $ti++;
			//$vju['price']['default'] = $value['price'];
			$cena = array( 
					$this->Form->input('Card.'.$i.'.price',$vju['price']),
					array('row' => $i)
			);
			$klient = array($tedane['Customer']['name'], array('class' => 'noinput'));
			

			$tablica[$i++] = array(
				$select,
				$nazwakarty,
				$ilosc,
				$mnoznik,
				$cena,
				$klient
			);
		}
		
		//echo '<pre>'; print_r($mnoznik); echo '</pre>';
		
		echo $this->Html->tag('table');
		echo $this->Html->tableHeaders(array(
				'', 'Nazwa karty',
				array('Ilość kart' => array('class' => 'cenaile')),
				array('mnożnik' => array('class' => 'mnoznik')),
				array('Cena' => array('class' => 'cenaile')),
				'Klient'
		));
		echo $this->Html->tableCells($tablica);
		echo $this->Html->tag('/table');
		
		echo $this->Html->tag('br');
		echo $this->Form->input('sposob_dostawy',$vju['sposob_dostawy']);
		echo $this->Form->input('osoba_kontaktowa',$vju['osoba_kontaktowa']);
		echo $this->Form->input('tel',$vju['tel']);		
		
		
		if( $tedane['Order']['sposob_dostawy'] == IA ) //iinny niż na fakturze
			$opcje = array('id' => 'extraadres' );
		else
			$opcje = array('id' => 'extraadres', 'style' => 'display: none' );
		
		
		echo $this->Html->tag('div', null, $opcje);
			
			echo $this->Html->tag('hr');
			echo $this->Form->input('AdresDostawy.id', array('type' => 'hidden'));
			echo $this->Form->input('AdresDostawy.name',$vju['nazwa']);
			echo $this->Form->input('AdresDostawy.ulica',$vju['ulica']);
			echo $this->Form->input('AdresDostawy.nr_budynku',$vju['nr_budynku']);
			echo '<br/>';
			echo $this->Form->input('AdresDostawy.kod',$vju['kod']);
			echo $this->Form->input('AdresDostawy.miasto',$vju['miasto']);
			echo $this->Form->input('AdresDostawy.kraj',$vju['kraj']);
			echo $this->Html->tag('br');

			echo $this->Html->tag('hr');		
		echo $this->Html->tag('/div');
		
		echo $this->Html->tag('br');
		echo $this->Form->input('comment',$vju['comment']);
		//echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Zapisz')); ?>
</div>
<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cards'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Card'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>

-->

