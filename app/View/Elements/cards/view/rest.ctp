<?php
//jeżeli karta ma jakies opcje sita to wyświetl tabelę
$cells = array();
if( $card['a_podklad'] || $card['r_podklad'] ) {
    $cells[] = array('podkład',
            $vju['x_sito']['options'][$card['a_podklad']],
            $vju['x_sito']['options'][$card['r_podklad']]
    );
    $cells[] = array('wybranie',
            $vju['yesno']['options'][$card['a_wybr']],
            $vju['yesno']['options'][$card['r_wybr']]
    );
}
if( $card['a_zadruk'] || $card['r_zadruk'] ) {
    $cells[] = array('zadruk',
            $vju['x_sito']['options'][$card['a_zadruk']],
            $vju['x_sito']['options'][$card['r_zadruk']]
    );
}
if( $card['a_podpis'] || $card['r_podpis'] ) {
    $cells[] = array('pasek do pod.',
            $this->Ma->card_view['x_podpis']['view'][$card['a_podpis']],
            $this->Ma->card_view['x_podpis']['view'][$card['r_podpis']]
    );
}
if( $card['a_zdrapka'] || $card['r_zdrapka'] ) {
    $cells[] = array('zdrapka',
                    $vju['yesno']['options'][$card['a_zdrapka']],
                    $vju['yesno']['options'][$card['r_zdrapka']]
    ); 
}
if( $card['a_lakpuch'] || $card['r_lakpuch'] )  {
    $cells[] = array('lakier puchnący',
                    $vju['yesno']['options'][$card['a_lakpuch']],
                    $vju['yesno']['options'][$card['r_lakpuch']]
    ); 
}
if( $card['a_lakblys'] || $card['r_lakblys'] ) {
    $cells[] = array('lakier błyszczący',
                    $vju['yesno']['options'][$card['a_lakblys']],
                    $vju['yesno']['options'][$card['r_lakblys']]
    ); 
}
if( !empty($cells) ) {
    echo $this->Ma->viewheader('OPCJE SITA', array('class' => 'masymetric'));
    echo $this->Html->tag('table', null, array('id' => 'cardsito', 'class' => 'cardviewtable'));
    echo $this->Html->tableHeaders(array('', 'awers', 'rewers'));
    echo $this->Html->tableCells($cells);
    echo $this->Html->tag('/table');
    echo '<div class="smallcomment"><p>uwagi:</p>'.nl2br($card['sito_comment']).'</div>'; 
}
$inne = null;
if( $card['mag'] ) {
    $inne .= $this->Html->tag('dt', 'pasek mag.', null);
    $inne .= $this->Html->tag('dd', $vju['mag']['options'][$card['mag']], null);
}
if( $card['chip'] ) {	
    $inne .= $this->Html->tag('dt', 'chip', null);
    $inne .= $this->Html->tag('dd', $vju['chip']['options'][$card['chip']], null);
}
if( $card['dziurka'] ) {	
    $inne .= $this->Html->tag('dt', 'dziurka', null);
    $inne .= $this->Html->tag('dd', $vju['dziurka']['options'][$card['dziurka']], null);
}
if( $card['ksztalt'] ) {	
    $inne .= $this->Html->tag('dt', 'kształt', null);
    $inne .= $this->Html->tag('dd', $vju['ksztalt']['options'][$card['ksztalt']], null);
}
if( $card['hologram'] ) {	
    $inne .= $this->Html->tag('dt', 'hologram', null);
    $inne .= $this->Html->tag('dd', $vju['hologram']['options'][$card['hologram']], null);
}
if( $card['wzor'] ) {	
    $inne .= $this->Html->tag('dt', 'Wzory / załączniki', null);
    $inne .= $this->Html->tag('dd', $vju['wzor']['options'][$card['wzor']], null);
}
if( $card['ishotstamp'] ) {	
    if( $card['ishotstamp'] == 2 ) { 
        $trzeci = array('class' => 'konec'); }
    else { $trzeci = null;}
    $inne .= $this->Html->tag('dt', 'Hotstamping', $trzeci);
    //$inne .= $this->Html->tag('dd', $vju['wzor']['options'][$card['wzor']], null);
}
$isperso = $card['isperso'];
if( $inne || !$isperso || $card['option_comment'] ) {
    $startdiv1 = $startdiv2 = $stopdiv = null;    
} else {
    $startdiv1 = $this->Html->tag('div', null, array('id' => 'perop1'));	
    $startdiv2 = $this->Html->tag('div', null, array('id' => 'perop2'));	
    $stopdiv = $this->Html->tag('/div');
}
echo '<div style="clear: both"></div>'; 
if( $isperso ) {
    $klasa = null;
    if( $card['status'] == KONEC || $card['pover'] ) {
       $klasa = ' pover-view';
    }
    $peropcje = null;
    if( $card['pl'] + $card['pt'] + $card['pe'] ) {
    // czyli są zaznaczone jakieś opcje
        $peropcje = 
        $this->Ma->perso3opcje['podlam-span'][$card['pl']] .
        $this->Ma->perso3opcje['plaska-span'][$card['pt']] .
        $this->Ma->perso3opcje['emboss-span'][$card['pe']];
    }
    echo $startdiv1;
    echo $this->Ma->viewheader('PERSONALIZACJA' . $peropcje, array('class' => 'margingor'));
    echo $this->Html->tag('p', nl2br($card['perso']), array('class' => 'comments' . $klasa));	
    echo $stopdiv;
}
if( $inne || $card['option_comment']) {
    echo $startdiv2;
    echo $this->Ma->viewheader('INNE OPCJE', array('class' => 'masymetric'));
    echo $this->Html->tag('dl', null, array('id' => 'innedl'));
    echo $inne;
    echo $this->Html->tag('/dl');
    echo '<div class="smallcomment"><p>uwagi:</p>'.nl2br($card['option_comment']).'</div>'; 
    echo $stopdiv;              
}
if( !empty($card['comment']) ) { //UWAGI KOŃCOWE
    echo $this->Ma->viewheader('UWAGI DO CAŁOŚCI:');
    echo $this->Html->tag('p', nl2br($card['comment']), array('class' => 'comments'));	
}