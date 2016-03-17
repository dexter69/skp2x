<?php 
//echo '<pre>';	print_r($juzer); echo  '</pre>'; 

//echo '<pre>';	print_r($buttons); echo  '</pre>'; 
//echo '<pre>';	print_r($bcontr); echo  '</pre>'; 
//echo '<pre>';	print_r($evcontrol); echo  '</pre>';
//echo '<pre>';	print_r($links); echo  '</pre>'; 
//echo '<pre>';	print_r($card['Proof']); echo  '</pre>'; 
//if( empty($card['Proof']) ) { echo 'EMPTY'; } else { echo 'NIE'; }
//echo '<pre>';	print_r($vju['x_sito']['options']); echo  '</pre>'; 

if( OLD_PDF_PROOF ) {
    $options = array('card.css?v=328496968', 'card-proof', 'font-awesome-4.5.0/css/font-awesome.min'); 
    $js_arr = array('card-perso', 'proof/proof'); }
else {
    $options = array('card.css?v=328496967');
    $js_arr = array('card-perso');}

echo $this->Html->css( $options, null, array('inline' => false));
echo $this->Html->script(array('event'), array('inline' => false)); 
echo $this->Ma->walnijJqueryUI();
echo $this->Ma->jqueryUItoolTip('.process, .persodate');
echo $this->Html->script($js_arr, array('block' => 'scriptBottom'));

$jscode = 'var theurl = "' . $this->Html->url(array('action' => 'addCzasPerso', 'ext' => 'json')) . '";';
$jscode .= "\n" . 'var myBase = "' . $this->webroot . '";';
$jscode .= "\n" . 'var card_id = "' . $card_id . '";';

echo $this->Html->scriptBlock($jscode, array('inline' => false));

$this->set('title_for_layout', $title);

$this->Ma->displayActions('cards');
