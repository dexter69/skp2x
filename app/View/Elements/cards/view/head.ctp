<?php 
//echo '<pre>';	print_r($juzer); echo  '</pre>'; 

//echo '<pre>';	print_r($buttons); echo  '</pre>'; 
//echo '<pre>';	print_r($bcontr); echo  '</pre>'; 
//echo '<pre>';	print_r($evcontrol); echo  '</pre>';
//echo '<pre>';	print_r($links); echo  '</pre>'; 
//echo '<pre>';	print_r($card['Proof']); echo  '</pre>'; 
//if( empty($card['Proof']) ) { echo 'EMPTY'; } else { echo 'NIE'; }
//echo '<pre>';	print_r($vju['x_sito']['options']); echo  '</pre>'; 

echo $this->Html->css(array(
    'card.css?v=328496968',
    'card-proof',
    'font-awesome-4.5.0/css/font-awesome.min'),
    null, array('inline' => false));
echo $this->Html->script(array('event'), array('inline' => false)); 
echo $this->Ma->walnijJqueryUI();
echo $this->Ma->jqueryUItoolTip('.process, .persodate');
echo $this->Html->script(array('card-perso'), array('block' => 'scriptBottom'));

$jscode = 'var theurl = "' . $this->Html->url(array('action' => 'addCzasPerso', 'ext' => 'json')) . '";';
$jscode .= "\n" . 'var myBase = "' . $this->webroot . '";';
echo $this->Html->scriptBlock($jscode, array('inline' => false));

$this->set('title_for_layout', $title);

$this->Ma->displayActions('cards');
