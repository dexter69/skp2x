<?php 
$this->set('title_for_layout', $title);

echo $this->Html->css(array('card.css?v=161102', 'custom-theme1/jquery-ui-1.10.4.custom.min'), null, array('inline' => false));
$this->Html->scriptBlock($jscode, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'card.js?v=161102'), array('inline' => false));

$this->Ma->displayActions($links); 

