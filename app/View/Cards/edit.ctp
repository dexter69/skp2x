<?php 

echo $this->element('cards/head', array(
    'title' => $this->request->data['Card']['name'],
    'jscode' => $jscode,
    'links' => $links
));

echo $this->element('cards/editForm', array(
    'vju' => $vju,
    'wspolne' => $wspolne
));

echo $this->element('cards/bottomJS', array( 'vju' => $vju ));
