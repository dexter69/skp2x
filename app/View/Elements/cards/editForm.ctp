<div id="kartedit" class="cards form">
<?php echo $this->Form->create('Card', array('type' => 'file')); ?>
    <fieldset>
        <legend>EDYCJA KARTY</legend>    
<?php

echo $this->Html->div("cards form", null, array('id' => 'kartedit'));
echo $this->Form->create('Card', array('type' => 'file')); 

echo $this->Form->input('id');
echo $this->Form->hidden('Card.user_id');
echo $this->Form->hidden('Card.owner_id', array( 'type' => 'text' ) );
echo $this->Form->hidden('Card.customer_id', array('label' => 'Klient', 'type' => 'text'));
echo $this->Form->hidden('Card.status');

$markup = 
    $this->Form->input('Card.name',$vju['name']) .
    $this->Form->input('klient', array('div' => array(
        'class' => 'input text required'), 'required' => true,
        'default' => $this->request->data['Customer']['name']
    ));
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
?>
        
</fieldset>
<?php echo $this->Form->end('Zapisz'); ?>
 
</div>

<?php

//$this->App->print_r2($this->request->data['Upload']); $this->App->print_r2($vju['rodo']);