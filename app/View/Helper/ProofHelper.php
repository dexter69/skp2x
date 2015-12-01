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
        
        $div = 
                ' data-lang="' . ($lang ? 'en' : 'pl') . '"' .
                ' data-locked="' . ($locked ? 'true' : 'false') . '"' .
                ' data-editable="' . ($editable ? 'true' : 'false') . '"';
        return array(
            'div' => $div,
            'iclass' => $locked ? 'fa fa-lock' : 'fa fa-unlock'
        );
    }
    
    // setup JS code - dane, powiązania dom ze zmiennymi bazy itp.
    public function setupJsCode( $proof = array(), $karta = array() ) {
        
        $tab = array(
            'Proof' => array(
                'id'  => $proof['id'],
                'card_id' => $karta['id'],
                'customer_nr' => $proof['customer_nr']
        )); 
        
        
        $jcode =  "var model =  " . json_encode( $tab );
        $this->Html->scriptBlock($jcode, array('block' => 'scriptBottom'));
        echo $this->Html->script(array('proof/proof'), array('block' => 'scriptBottom'));
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
            array(date("d.m.Y"), array('id' => 'burok', 'contenteditable' => 'true')),
            $dane['handlowe'],
            $dane['ilosc'],
            $dane['cena'] . " " . $dane['waluta'] . ($dane['lang'] ? "/pc." : "/szt."),
            array($dane['customer_nr'], array('class' => 'pedit', 'name' => 'data[Proof][customer_nr]'))//$dane['customer_nr']
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
            'customer_nr' => $karta['Proof']['customer_nr'],
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


