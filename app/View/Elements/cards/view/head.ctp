<?php 
//echo '<pre>';	print_r($juzer); echo  '</pre>'; 

$options = $this->App->makeCssJsTable(["card"], 'css'); //array('card.css?v=201701241015');
$js_arr = array('card-perso');

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
