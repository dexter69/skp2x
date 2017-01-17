<?php 

echo $this->element('cards/head', array(
    'title' => $this->request->data['Card']['name'],
    'jscode' => $jscode,
    'links' => $links
));

// mała poprawka, by edycja karty z zakóńczonym hotstampingiem działała poprawnie
if( $this->request->data['Card']['ishotstamp'] == 2 ) {
    unset($vju['hotstamp']['options'][1]);
    $vju['hotstamp']['options'][2] = 'TAK';
}

echo $this->element('cards/editForm', array(
    'vju' => $vju,
    'wspolne' => $wspolne
));

echo $this->element('cards/bottomJS', array( 'vju' => $vju ));

//$this->App->print_r2($vju);
//$this->App->print_r2($this->request->data);
