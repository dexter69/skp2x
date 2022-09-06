<?php

$klientClass = 'input text required';
if ( !$tylkoDlaSwoich ) {
    $klientClass .= ' click';
}

echo $this->element('cards/head', array(
    'title' => 'Nowa karta',
    'jscode' => $jscode,
    'links' => $links
));

echo $this->element('cards/addForm', array(    
    'ownerid' => $ownerid,
    'vju' => $vju,
    'wspolne' => $wspolne,
    'klientClass' => $klientClass
));

echo $this->element('cards/bottomJS', array( 'vju' => $vju ));

