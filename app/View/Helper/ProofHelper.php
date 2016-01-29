<?php

App::uses('AppHelper', 'View/Helper');

class ProofHelper extends AppHelper {
    
    public $helpers = array('Ma', 'Html');
    
    // dane do obsługi językowej proof'a
    private $lng = array( // w tablicach kolejność: pl, en
        array('DATA', 'DATE'),
        array('ZAMÓWIENIE', 'ORDER NUMBER'),
        array('ILOŚĆ', 'QUANTITY'),
        array('CENA', 'PRICE'),
        array('ZAMÓWIENIE KLIENTA', "CUSTOMER'S ORDER No.")
    );
    // parametry strony
    public function parametry( $lang, $locked, $editable) {
        
        $class =    'class="proof-stuff ' . ($lang ? 'en ' : 'pl ') . 
                    ($locked ? 'locked ' : 'unlocked ') .
                    ($editable ? 'edit-yes' : 'edit-no') . '"';
        
        return array(            
            'class' => $class,
            'iclass' => $locked ? 'fa fa-lock' : 'fa fa-unlock'
        );
    }
    
    // setup JS code - dane, powiązania dom ze zmiennymi bazy itp.
    public function setupJsCode($proof = array(), $karta = array(),
                                $currency = 'PLN',$wju = array(), $jazyk = 0 ) {
        
        $string = ($jazyk ? '85 x 54 x 0.76 mm' : '85 x 54 x 0,76 mm');
        // Założenie: defaultowe wartości pól dla proof'a są null (za wyjątkiem size)
        if( $proof['size'] ) { // wpis w bazie już istnieje
            $size = $proof['size']; }
        else { // $karta['ksztalt'] > 0 znaczy, że kształt jest niestandardowy
            $size = ( $karta['ksztalt'] ? null : $string);}
        $kolory = array();
        $kolory['a'] = ( $proof['a_kolor'] ? $proof['a_kolor'] : $this->proofKolor('a', $karta, $wju, $jazyk) );
        $kolory['r'] = ( $proof['r_kolor'] ? $proof['r_kolor'] : $this->proofKolor('r', $karta, $wju, $jazyk) );
        $waluta = ( $proof['waluta'] ? $proof['waluta'] : $currency);
        
        /*
        $model = $this->setModel($proof, $karta, $waluta, $kolory, $size);
        
        $jcode =  "var model =  " . json_encode( $model );
        */
    }
    
    // setup JS code - dane, powiązania dom ze zmiennymi bazy itp.
    public function setupJsCode2($proof = array(), $karta = array(),
                                $currency = 'PLN',$wju = array(), $jazyk = 0 ) {
        
        $string = ($jazyk ? '85 x 54 x 0.76 mm' : '85 x 54 x 0,76 mm');
        // Założenie: defaultowe wartości pól dla proof'a są null (za wyjątkiem size)
        if( $proof['size'] ) { // wpis w bazie już istnieje
            $size = $proof['size']; }
        else { // $karta['ksztalt'] > 0 znaczy, że kształt jest niestandardowy
            $size = ( $karta['ksztalt'] ? null : $string);}
        $kolory = array();
        $kolory['a'] = ( $proof['a_kolor'] ? $proof['a_kolor'] : $this->proofKolor('a', $karta, $wju, $jazyk) );
        $kolory['r'] = ( $proof['r_kolor'] ? $proof['r_kolor'] : $this->proofKolor('r', $karta, $wju, $jazyk) );
        $waluta = ( $proof['waluta'] ? $proof['waluta'] : $currency);
        
        $model = $this->setModel($proof, $karta, $waluta, $kolory, $size);
        
        $jcode =  "var model =  " . json_encode( $model );
        $this->Html->scriptBlock($jcode, array('block' => 'scriptBottom'));
        echo $this->Html->script(array('proof/proof'), array('block' => 'scriptBottom'));
    }
    
    private function setModel($proof, $karta, $waluta, $kolory, $size) {
        
        $model = array(
            'Proof' => array(
                'id'  => $proof['id'],
                'card_id' => $karta['id'],
                'customer_nr' => $karta['customer_nr'],
                'waluta' => $waluta,
                'a_kolor' => $kolory['a'],
                'r_kolor' => $kolory['r'],
                'size' => $size,
                'uwagi' => $proof['uwagi'],
            ),
            'bind' => array(    // "połączenia" z elementami widoku i formularza
                'view' => array(),
                'edit'  => array()
            )
        ); 
        return $model;
    }
    
    private function proofKolor( $ar, $card = array(), $vju = array(), $lang = 0) {
        
        $word = ($lang ? 'pantons' : 'pantony');  //$lang != 0 - język angielski
        $ret = null;
        if( $ar == 'a' ) {
            $ret =  $vju['x_c']['options'][$card['a_c']].
                    $vju['x_m']['options'][$card['a_m']].
                    $vju['x_y']['options'][$card['a_y']].
                    $vju['x_k']['options'][$card['a_k']];
            if( $card['a_pant'] ) { $ret .= ", $word: " . $card['a_pant']; }}
        else {
            $ret =  $vju['x_c']['options'][$card['r_c']].
                    $vju['x_m']['options'][$card['r_m']].
                    $vju['x_y']['options'][$card['r_y']].
                    $vju['x_k']['options'][$card['r_k']];        
            if( $card['r_pant'] ) { $ret .= ", $word: " . $card['r_pant']; }}
        return $ret;
    }
    
    // górna tabela
    public function topTable( $dane = array()) {
        
        $hdata = array();
        foreach( $this->lng as $rowek ) {
           $hdata[] = array(
               $rowek[$dane['lang']] => array('data-en' => $rowek[1], 'data-pl' => $rowek[0])
           );
        }
        $the_html = '<table class="proof1" cellpadding="0" cellspacing="0"><thead>';
        $the_html .= $this->Html->tableHeaders($hdata) . '</thead><tbody>';
        $cells = array(
            array(date("d.m.Y"), array('id' => 'burok')),
            $dane['handlowe'],
            $dane['ilosc'],
            $dane['cena'] . " " . $dane['waluta'] . ($dane['lang'] ? "/pc." : "/szt."),
            array(  $dane['customer_nr'], array(
                        'class' => 'pedit',
                        'name' => 'data[Proof][customer_nr]',
                        'contenteditable' => 'false'
            ))//$dane['customer_nr']
        );
        $the_html .= $this->Html->tableCells( array($cells) ) . '</tbody></table>';
                
        return $the_html;
    }
    
    // Wspólne zmienne dla widoku karty i podglądu proof'a (co by 2x nie obliczać)
    public function wspolne( $karta = array()) {
        
        $tablica = array(
            'handlowe' => $this->nrHandlowego($karta),
            'ilosc' => $this->ileKart($karta),
            'cena' => $this->cenaKarty($karta),
            'customer_nr' => $karta['Card']['customer_nr'],
            'waluta' => $karta['Customer']['waluta'],
            'lang' => $karta['Customer']['proof-lang']
        );
        
        
        return $tablica;
    }
    
    private function nrHandlowego( $karta = array() ) {
        
        if( $karta['Order']['id'] ) {
            if( $karta['Order']['nr'] ) { 
                return $this->bnr2nrh($karta['Order']['nr']);
            } else  { 
                return 'id = '. $karta['Order']['id']; }                
        }
        return null;
    } 
    
    private function bnr2nrh($bnr = null) {
        
        return (int)substr((int)$bnr,2).'/'.substr((int)$bnr,0,2);        
    }	
    
    private function ileKart( $karta = array() ) {
        
        if( $karta['Card']['ilosc'] )   {
            return $this->Ma->tys($karta['Card']['ilosc']*$karta['Card']['mnoznik']); }
        return null;
    }
    
    private function cenaKarty($karta = array()) {
        
        if( $karta['Card']['price'] ) {
            return $this->Ma->colon($karta['Card']['price']);
        }
        return $karta['Card']['price'];
    }
    
    
    // uproszczenie w cakowych widokach
    public function dtdd( $dt = null, $dd = null) {
            echo "<dt>$dt</dt><dd>$dd&nbsp;</dd>";
    }
    
    public function dd( $dd = null, $atr = array() ) {
            
            $out = '<dd';
            foreach($atr as $key => $val ) {
                $out .= " $key=" . '"' . $val . '"';
            }
            $out .= ">$dd&nbsp;</dd>";
            echo $out;
    }
    
    public function printR( $zm ) {
        
        echo '<pre>'; print_r($zm); echo '</pre>'; 
    }
}


