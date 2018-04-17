<?php 

echo $this->element('cards/head', array(
    'title' => 'Nowa karta',
    'jscode' => $jscode,
    'links' => $links
));

echo $this->element('cards/addForm', array(    
    'ownerid' => $ownerid,
    'vju' => $vju,
    'wspolne' => $wspolne
));

echo $this->element('cards/bottomJS', array( 'vju' => $vju ));

