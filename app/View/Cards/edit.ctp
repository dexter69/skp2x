<?php 

// do sekcji head zostanie dodany project.css
echo $this->Html->css(array('card', 'custom-theme1/jquery-ui-1.10.4.custom.min'), null, array('inline' => false));
$this->Html->scriptBlock($jscode, array('inline' => false));
echo $this->Html->script(array('jquery', 'jquery-ui', 'card'/*, 'common'*/), array('inline' => false)); 
//echo $this->Html->script('card', array('block' => 'scriptBottom')); 

//echo '<pre>';	print_r($tbl[2]); echo  '</pre>';

//echo '<pre>';	print_r($uploads); echo  '</pre>';
//echo '<pre>';	print_r($customers); echo  '</pre>';
//echo '<pre>';	print_r($this->request->data); echo  '</pre>';
//echo '<pre>';	print_r($wspolne); echo  '</pre>';
//echo '<pre>';	print_r($karty); echo  '</pre>';

//echo '<pre>';	print_r($ownerid); echo  '</pre>';
//echo '<pre>';	print_r($tmp); echo  '</pre>';
$this->Ma->displayActions($links); 
?>
<div id="kartedit" class="cards form">
<?php echo $this->Form->create('Card', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('EDYCJA KARTY'); ?></legend>
	<?php
	
		echo $this->Form->input('id');
		echo $this->Form->hidden('Card.user_id');
		echo $this->Form->hidden('Card.owner_id', array( 'type' => 'text'/*, 'default' => $this->request->data['Card']['owner_id']*/ ) );
		echo $this->Form->hidden('Card.customer_id', array('label' => 'Klient', 'type' => 'text'/*, 'default' => 0*/));
		echo $this->Form->hidden('Card.status');
		
		
		$markup =	$this->Form->input('Card.name',$vju['name']) .
					//$this->Form->input('Card.customer_id', array('label' => 'Klient', 'type' => 'text'));
					$this->Form->input('klient', array('div' => array(
										'class' => 'input text required'), 'required' => true,
										'default' => $this->request->data['Customer']['name']));
		$this->Ma->responsive_divs( $markup, 'karta_klient');
					
		
							
		echo $this->Ma->viewheader('MATERIAŁ, KOLORYSTYKA', array('class' => 'masymetric')); 
		$this->Ma->responsive_divs( $this->Ma->make_cmyk($vju), 'cmykownia');
		
		echo $this->Ma->viewheader('OPCJE SITA', array('class' => 'masymetric')); 
		$this->Ma->responsive_divs( $this->Ma->make_sito($vju), 'sitoza');
		
		
		echo $this->Ma->viewheader('INNE OPCJE', array('class' => 'masymetric')); 
		$this->Ma->responsive_divs( $this->Ma->make_options($vju), 'moreoptions');
		
				
		$this->Ma->responsive_divs( $this->Ma->make_perasoAndFcomment($vju), 'perso_and_comm');
		
		//do przechowywania personalizacji
		echo $this->Form->hidden('perso_help', array('default' => $this->request->data['Card']['perso']));
		
		echo $this->Ma->viewheader('PLIKI');
		
		echo $this->Ma->zalaczone_pliki($this->request->data['Upload'], $vju );
		
		//pozbywamy się plików które są już wyświetlane jako załączone do tej karty.
		$wspolne = $this->Ma->oczysc_wspolne($wspolne, $this->request->data['Upload']);
			
		echo $this->Ma->wspolne_pliki($wspolne); 
		//echo $this->Html->tag('hr');
		
		echo $this->Form->input('Upload.files.',$vju['file']);
		
		echo $this->Html->tag('table', '', array('id' => 'filetable'));
		/*
		if ( !empty($uploads) ) {
			echo $this->Form->input('Upload',array('label'=>'Pliki dodane z innymi kartami'));
		}
		*/
		
		
		
/*
	Wykorzystujemy metode input do wykreowania potrzebnego kodu html a następnie przygotowujemy go
	dla javascriptu i umieszczamy go w thehtml
	UWAGA! istotna jest dana wejściowa PATT.'.role', gdyż skrypty z upload.js tego szuka
*/
		
					
		$html2 = json_encode(
						$this->Form->input('Upload.'.PATT.'.role',$vju['role']) .
						'</td><td>' . $this->Form->input('Upload.'.PATT.'.roletxt',$vju['roletxt']) 
					);
					
		$html1 = json_encode(
					$this->Form->input('Upload.'.PATT.'.checkbox',
							array( 'type' => 'checkbox', 'label' => false, 'div' => false, 'checked' => true))
		);
		
		
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Zapisz')); ?>
</div>


<?php 
	$this->Html->scriptStart( array('block' => 'scriptBottom') ); ?>

$( document ).ready(function() {
	
	ufs( <?php echo $html1 ?>, <?php echo $html2 ?>, <?php echo PATT ?> );
	
});

<?php $this->Html->scriptEnd(); 
/*
echo '<pre>';	print_r(
	$this->request->data['Upload']
	); echo  '</pre>';
*/
//echo '<pre>';	print_r(
	//$this->request->data
	//$wspolne
//); echo  '</pre>';
	
	

?>
