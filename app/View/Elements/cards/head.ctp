<?php 
$this->set('title_for_layout', $title);

//echo $this->Html->css(array('card.css?v=' . time(), 'custom-theme1/jquery-ui-1.10.4.custom.min'), null, array('inline' => false));

echo $this->Html->css(
    $this->App->makeCssJsTable(
        ['card', 'custom-theme1/jquery-ui-1.10.4.custom.min'],
        'css'
    ),
    null,
    ['inline' => false]
);

$this->Html->scriptBlock($jscode, array('inline' => false));

echo $this->Html->script(    
    $this->App->makeCssJsTable(['jquery-ui', 'card-multi', 'card'],'js'),
    ['inline' => false]
);

$this->Ma->displayActions($links); 

