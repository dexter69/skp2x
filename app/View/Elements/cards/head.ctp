<?php 
$this->set('title_for_layout', $title);

echo $this->Html->css(array('card.css?v=' . time(), 'custom-theme1/jquery-ui-1.10.4.custom.min'), null, array('inline' => false));
$this->Html->scriptBlock($jscode, array('inline' => false));
echo $this->Html->script([
    'jquery-ui',
    'card-multi.js?v=' . time(),
    'card.js?v=' . time(),
    ],
    array('inline' => false)
);

$this->Ma->displayActions($links); 

