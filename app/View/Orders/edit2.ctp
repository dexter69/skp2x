<?php 
// do sekcji head zostanie dodany customer.css
//jquery-ui-1.10.4.custom.min
$tedane = $this->request->data;
echo $this->Html->css(array('order', 'sunny/jquery-ui-1.10.4.custom.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery', 'jquery-ui', 'jquery.ui.datepicker-pl'/*, 'common'*/), array('inline' => false)); 
$code = //"var platnosci = " . json_encode($tedane['platnosci']) . ";\n" .
		"var pay = " . json_encode( array( PRZE, CASH ) ) . ";\n" .
		"var defproc = " . json_encode(DEF_ZAL_PROC) . ";\n" .
		"var adres = " . json_encode($tedane['AdresDoFaktury'], JSON_UNESCAPED_UNICODE) . ";\n" .
		"var czas_realiz = " . ORD_TIME . ";\n" .
		"var stop_day = " . json_encode( substr($tedane['Order']['stop_day'], 2) ) . ";";
		
echo $this->Html->scriptBlock($code, array('block' => 'scriptBottom'));
echo $this->Html->script( 'order-edit', array('block' => 'scriptBottom')); 

//echo '<pre>'; print_r($vju['forma_zaliczki']); echo '</pre>';
//echo '<pre>'; print_r($vju['forma_platnosci']); echo '</pre>';
//echo '<pre>'; print_r($vju['osoba_kontaktowa']); echo '</pre>';
//echo '<pre>'; print_r($vju['sposob_dostawy']); echo '</pre>';

//echo '<pre>'; print_r($karty); echo '</pre>';
//echo '<pre>'; print_r($karty2); echo '</pre>';
//echo '<pre>'; print_r($adresy); echo '</pre>';
//echo '<pre>'; print_r($adresy2); echo '</pre>';
//echo '<pre>'; print_r($links); echo '</pre>';
//echo '<pre>'; print_r($tedane); echo '</pre>';
//echo '<pre>'; print_r($tedane['Card']); echo '</pre>';

//if( $platnosci == $platnosci2 ) echo 'TO SAMO';
$this->Ma->displayActions($links);


?>

<div class="orders form">
<?php echo $this->Form->create('Order'); $this->Ma->nawiguj( $links );?>
	<fieldset>
		<legend><?php echo __('EDYCJA ZAMÓWIENIA (H)'); ?></legend>
	<?php
		
		echo $this->Form->hidden('id');
		echo $this->Form->input('customer_id', array('type' => 'hidden', 'default' => 0));
		echo $this->Form->input('siedziba_id', array('type' => 'hidden', 'default' => 0));


		// KARTY
		$i=0;	$tablica =  array();
		foreach ($tedane['Card'] as $karta) {
			
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
			
			$nazwakarty = $this->Html->link($karta['name'],
    		    		array('controller' => 'cards', 'action' => 'view', $karta['id']));
				
			$vju['ilosc']['disabled'] = true;
			$ilosc = array(  
					$this->Form->input('Card.'.$i.'.ilosc',$vju['ilosc']),
					array('row' => $i)
			);
			$mnoznik = array(  
					$this->Form->input('Card.'.$i.'.mnoznik',$vju['mnoznik']),
					array('class' => 'mnoznik')
			);
			$vju['price']['disabled'] = true;
			$cena = array( 
					$this->Form->input('Card.'.$i.'.price',$vju['price']),
					array('row' => $i++)
			);
			$klient = $this->Html->link($tedane['Customer']['name'],
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
		
		echo $this->Ma->viewheader('KARTY', array('class' => 'margin01') );
		echo $this->Html->tag('table',null, array('id' => 'ordcards'));
		/*
		echo $this->Html->link(
    		'Delete',
    		array('controller' => 'recipes', 'action' => 'delete', 6),
    		array(),
    		"Are you sure you wish to delete this recipe?"
		);
		*/
		echo $this->Html->tableHeaders(array(
				'', 'Nazwa karty',
				array('Ilość kart' => array('class' => 'cenaile')),
				array('Mnożnik' => array('class' => 'mnoznik')),
				array('Cena' => array('class' => 'cenaile')),
				'Klient'
		));
		echo $this->Html->tableCells($tablica);
		echo $this->Html->tag('/table');

		//OPCJE PŁATNOŚCI
		echo $this->Html->div('view_wrap', null, array('id' => 'paywrap'));
			echo $this->Ma->viewheader('OPCJE PŁATNOŚCI', array( 'id' => 'p_pay'));
			echo $this->Html->tag('div');
				echo $this->Form->input('forma_zaliczki',$vju['forma_zaliczki']);
				echo $this->Form->input('forma_platnosci',$vju['forma_platnosci']);
			echo $this->Html->tag('/div');
			echo $this->Html->tag('div');
				echo $this->Form->input('procent_zaliczki',$vju['procent_zaliczki']);			
				echo $this->Form->input('termin_platnosci',$vju['termin_platnosci']);
			echo $this->Html->tag('/div');
			echo $this->Form->hidden('prc');
			echo $this->Form->hidden('trm');
		echo $this->Html->tag('/div');	


		//KALENDARZYK
		echo $this->Form->hidden('hdate');
		echo $this->Html->div('datepickerwrap');
			//echo $this->Html->tag('p', 'DATA ZAKOŃCZENIA', array('class' => 'viewheader '));
			echo $this->Ma->viewheader('DATA ZAKOŃCZENIA');
			//echo $this->Html->tag('label', 'Data zakończenia');
			echo $this->Html->div(null, '', array('id' => 'datepicker'));
			echo $this->Form->hidden('isekspres');
			echo $this->Html->div(null, 'EKSPRES', array('id' => 'ekspresorder'));
		echo $this->Html->tag('/div');


		//echo $this->Html->tag('p', '', array('class' => 'fbreak'));
		
		
		echo $this->Html->div('view_wrap', null, array('id' => 'adrwrap'));
			echo $this->Ma->viewheader('OPCJE DOSTAWY', array('class' => 'margindol') );
			//echo $this->Form->input('sposob_dostawy', $vju['sposob_dostawy']);
			echo $this->Form->input('osoba_kontaktowa', $vju['osoba_kontaktowa']);
			echo $this->Form->input('tel',$vju['tel']);		
		echo $this->Html->tag('/div');	
		
		echo $this->Html->div('view_wrap',null,array('id' => 'extraadres'));
			echo $this->Ma->viewheader('INNY ADRES WYSYŁKI');
			echo $this->Form->input('sposob_dostawy', $vju['sposob_dostawy']);
			echo $this->Form->input('AdresDostawy.name',$vju['nazwa']);
			echo $this->Form->input('AdresDostawy.ulica',$vju['ulica']);
			echo $this->Form->input('AdresDostawy.nr_budynku',$vju['nr_budynku']);
			//echo $this->Html->tag('p', '', array('class' => 'fbreak'));
			echo $this->Form->input('AdresDostawy.kod',$vju['kod']);
			echo $this->Form->input('AdresDostawy.miasto',$vju['miasto']);
			echo $this->Form->input('AdresDostawy.kraj',$vju['kraj']);
			//echo $this->Html->tag('p', '', array('class' => 'fbreak'));
		echo $this->Html->tag('/div');
		
		//echo $this->Html->tag('p', '', array('class' => 'fbreak'));
		
		echo $this->Html->div('view_wrap', null, array('id' => 'commentwrap'));
			echo $this->Ma->viewheader('UWAGI', array('class' => 'margindol'));
			echo $this->Form->input('comment', array('label' => false));
		echo $this->Html->tag('/div');
		//echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Zapisz')); ?>
</div>

<?php echo '<pre>'; print_r($tedane); echo '</pre>'; ?>


