<?php

App::uses('AppHelper', 'View/Helper');

class PdfHelper extends AppHelper {
    
    public $helpers = array('Html', 'Ma');
    
    public function order_naglowekTable( $zam = array() ) {
        
        if( empty($zam) ) {
            $markup = null;
        } else {
            $kolumna1 = 
                    '<p class="termin">' . $this->Ma->md($zam['Order']['stop_day']) . '</p>' .
                    //'<p class="termin">' . '22 październik 2015' . '</p>' .
                    //'<p class="naklad">' . $zam['Order']['naklad'] . '</p>' .
                    '<p class="klient">' . $zam['Customer']['name'] . '</p>' 
                     
                    ;
            
            $kolumna2 = '<p class="ord-nr">'.$this->Ma->bnr2nrh($zam['Order']['nr'], $zam['User']['inic'], false).'</p>'
                        //. '<p>' . $this->Ma->md($zam['Order']['stop_day']) . '</p>'
                        ;            
            if( $zam['Order']['isekspres'] ) { $kolumna2 .= '<p class="ekspres">EKSPRES</p>'; }
            $markup = '<table cellspacing="0" cellpadding="0">' .
                    $this->Html->tableHeaders( array(
                        array('' => array('class' => 'td1')), 
                        array('' => array('class' => 'nr-col'))
                    ) ) .
                    $this->Html->tableCells(array(
                        array(array($kolumna1, array('class' => 'td1')), array($kolumna2, array('class' => 'nr-col'))),                        
                    )) .
                    '</table>'
                    ;
        }
        return $markup;
        
    }
    
    public function order_kartyTable( $cardArray = array() ) {
        
        $tablica = $this->tablicaKart($cardArray);
        $retab = array('ilosc' => $tablica['ilosc'], 'markup' => null);
        $retab['markup'] = 
            '<table cellspacing="0" cellpadding="0">' .
                $this->Html->tableHeaders( $tablica['header'] ) .
                $this->Html->tableCells($tablica['body'], null, array('class' => 'darker')) .
            '</table>';
        return $retab;
    }
    
    private function tablicaKart( $cardArray = array() )  {
        
        $retab = array('ilosc' => 0, 'header' => array(), 'body' => array());
        if( !empty($cardArray) ) {
            foreach( $cardArray as $karta ) {
                if( $karta['isperso'] ) { $perso = 'P'; } else { $perso = null; }
                $jobnr = null;
                if( $karta['job_nr'] ) {
                    $jobnr = $this->Ma->bnr2nrj($karta['job_nr'], null);
                }                
                $retab['body'][] = array(
                    array($karta['id'], array('class' => 'id')),
                    array($perso, array('class' => 'perso')),
                    array($karta['name'], array('class' => 'nazwa')),
                    array($jobnr, array('class' => 'jobnr')),
                    array($this->Ma->tys($karta['quantity']), array('class' => 'ile')),
                    array($this->Ma->colon($karta['price']), array('class' => 'cena')),
                );
                $retab['ilosc'] += $karta['quantity'];
            }
            $retab['body'][] = array(
                    array('', array('class' => 'id')),
                    array('', array('class' => 'perso')),
                    array('', array('class' => 'nazwa')),
                    array('', array('class' => 'jobnr')),
                    array($this->Ma->tys($retab['ilosc']), array('class' => 'ile')),
                    array('', array('class' => 'cena'))
                );
            $retab['header'] = array(
                        array('id' => array('class' => 'id')), 
                        array('' => array('class' => 'perso')),
                        array('nazwa karty' => array('class' => 'nazwa')),
                        array('zlecenie' => array('class' => 'jobnr')),
                        array('ilość' => array('class' => 'ile')),
                        array('cena' => array('class' => 'cena'))
            ); 
        }
        return $retab;
    }
    
    public function order_adresyUwagiTable( $zam = array() ) {
        
        if( empty($zam) ) {
            $markup = null;
        } else {
            $kolumna1 = //'<p class="nag">Uwagi:</p>' .
                        '<p class="grubszy-nag">Uwagi</p>' . nl2br($zam['Order']['comment']);
            $kolumna2 = '<div><p class="grubszy-nag">Adres do faktury</p>' . 
                            $this->Ma->adresFaktury($zam) . 
                            '<p><label>NIP</label>' . $zam['Customer']['vatno_txt'] . '</p>' .
                        '</div>' .
                        '<div><p class="grubszy-nag">Adres dostawy</p>' . $this->Ma->adresDostawy($zam) . '</div>' .
                        '<div><p class="grubszy-nag">Osoba kontaktowa</p>' . 
                            '<p>' . $zam['Order']['osoba_kontaktowa'] . '</p>' . '<p>' . $zam['Order']['tel'] . '</p></div>' .
                        '<div class="kasa"><p class="grubszy-nag">Opcje płatności</p>' . '<p><label>Przedpłata:</label>' . $zam['Order']['przedplata'] . '</p>' . 
                            '<p><label>Forma płatności:</label>' . $zam['Order']['forma'] . '</p>' .
                            '<p><label>Waluta:</label>' . $zam['Customer']['waluta'] . '</p></div>'
                                  
                    ;
                        
            $markup = '<table cellspacing="0" cellpadding="0">' .
                    $this->Html->tableHeaders( array(
                        '', 
                        array('' => array('class' => 'adresy'))
                    ) ) .
                    $this->Html->tableCells(array(
                        array(array($kolumna1, array('class' => 'uwagi')), array($kolumna2, array('class' => 'adresy'))),                        
                    )) .
                    '</table>'
                    ;
            //$markup = nl2br($zam['Order']['comment']);
        }
        return $markup;
        
    }
    
    public function job_PrintNaglowek( $zle = array() ) {
        
        if( empty($zle) ) {
            $markup = null;
        } else {
            $kolumna1 = 
                    '<p class="job-nr">'.$this->Ma->bnr2nrj($zle['Job']['nr'], null, true).'</p>' 
                    
                    ;
                    
            $arkuszediv = '<div class="arkuszediv"><p class=""><label>rodzaj arkusza:</label>'.$this->Ma->arkusz[$zle['Job']['rodzaj_arkusza']].'</p>' .
                        '<p class="off-zwyz"><label>zwyżka dla offsetu:</label>' . $zle['Job']['dla_drukarzy'] . '</p>' .
                        '<p class="lam-zwyz"><label>arkusze do laminacji:</label>' . $this->Ma->tys($zle['Job']['dla_laminacji']) . '</p></div>' ;
            
            $kolumna2 = '<p class="job-termin">' . $this->Ma->md($zle['Job']['stop_day']) . '</p>';
                        
            $markup = '<div class="naglowek"><div class="job-pdf-left"><table cellspacing="0" cellpadding="0" class="job-pdf-table">' .
                                        
                    $this->Html->tableCells(array(
                        array(
                            array($kolumna1, array('class' => 'nr-col')),                             
                            array($kolumna2, array('class' => 'k2'))
                        )                        
                    )) .
                    '</table>' . $arkuszediv . '</div>' .
                    '<div class="job-pdf-right">' .
                        '<p class="job-uwagi">' . nl2br($zle['Job']['comment']) . '</p>'  .
                    '</div></div>';
            
        }
        return $markup;
        
    }
    
    
    public function job_PrintKarte( $karta = array() ) {
        
        if( empty( $karta ) ) {
            $markup = null;
        } else {
           $markup =
                   '<div class="info-o-karcie">' . 
                        //'<p>'.$karta['name'].'</p>'.
                        $this->job_cardHead($karta) .
                        $this->job_tablicaOpcji( $karta ) .
                   '</div>';
        }
        return $markup;
    }
    
    private function job_cardHead( $karta = array() )  {
        //array($karta['id'], array('class' => 'id'))
        return  '<table cellspacing="0" cellpadding="0" class="table-in-head">' .
                '<tr><th><label>karta</label></th><th class="ilosc"><label>ilość</label></th><th class="klient"><label>klient</label></th><th class="ordernr"><label>nr handlowy</label></th><th class="termin"><label>termin</label></th><tr>' .
                $this->Html->tableCells(array(
                    //array($karta['name'], array('class' => 'nazwa')),
                    //array($karta['name'], array('class' => 'sdfdsf')),
                    //'bdfkjsdhfkjsdhfkjsdhfbdfkjsdhfkjsdhfkjsdhfbdfkjsdhfkjsdhfkjsdhf'.
                    $karta['name'],//.'<label class="card-head">karta</label>',
                    array( $this->Ma->tys($karta['quantity']), array('class' => 'ilosc') ),
                    $karta['klient'],                    
                    array( $this->Ma->bnr2nrh($karta['nr_zamowienia'],  $karta['inic'], false), array('class' => 'ordernr')),
                    array($this->Ma->md($karta['termin'], true), array('class' => 'termin'))
                //$karta['termin'] = $this->Ma->md($ordery[$karta['id']]['Order']['stop_day'], true);
                    //$karta['nr_zamowienia']
                //bnr2nrj($bnr = null, $inicjaly = null, $ishtml = true)
                )) .
                '</table>';
                /*
                '<p>' . 
                    '<span>' . $karta['name'] . '</span>' .
                    '<span>' . $karta['klient'] . '</span>' .
                '</p>';
                */
    }
    
    private function job_tablicaOpcji( $karta = array() )  {
        
        $to = $this->transform( $karta );
        
        $tab_naglowek = array(
                            array('' => array('class' => 'aw')),
                            array('mater' => array('class' => 'materia')),
                            array('sito przed' => array('class' => 'sito-przed')),
                            array('cmyk' => array('class' => 'cmyk')),
                            array('pant' => array('class' => 'panton')),
                            array('sito zadruk' => array('class' => 'zadruk')),
                            array('laminat' => array('class' => 'laminat')),
                            array('mag' => array('class' => 'mag')),
                            array('sito po' => array('class' => 'sipo')),
                            array('pasek' => array('class' => 'pasek')),
                            array('perso' => array('class' => 'perso'))
                            //, array('uwagi' => array('class' => 'rest')),
                            //array('pas' => array('class' => 'pp'))
                        );
        
        $tab_body = array( array( 
            array( $to['aw'], array('class' => 'aw') ),
            array( $to['materia'], array('class' => 'materia') ),
            array( $to['sito-przed'], array('class' => 'sito-przed') ),
            array( $to['cmyk'], array('class' => 'cmyk') ), 
            array( $to['panton'], array('class' => 'panton') ),
            array( $to['zadruk'], array('class' => 'zadruk') ),
            array( $to['laminat'], array('class' => 'laminat') ),
            array( $to['mag'], array('class' => 'mag') ),
            array( $to['sipo'], array('class' => 'sipo') ),
            array( $to['pasek'], array('class' => 'pasek') ),
            array( $to['perso'], array('class' => 'perso') )
            //,array( '', array('class' => 'rest') )
        ));
        
        $markup = 
            '<div class="opcje-tab-div-around szer' . $to['ilesipo'] .  '">' .
                '<table cellspacing="0" cellpadding="0" class="opcje-tab">' .
                    $this->Html->tableHeaders( $tab_naglowek ) .
                    $this->Html->tableCells($tab_body) .
                '</table>' .
            '</div>' .
            '<div class="uwagi-techniczne-do-karty szer' . $to['ilesipo'] . '"><b>uwagi:</b> ' . 
              nl2br($karta['tech_comment']) .
            '</div>';
        return $markup;
    }
    
    private function transform( $karta = array() )  {
        
        $tab = array();
        $tab['aw'] = 'awers<br>rewers';
        $tab['materia'] = $this->materialJobPdf($karta);
        $tab['sito-przed'] = $this->siprzedJobPdf($karta);
        $tab['cmyk'] = $this->cmykJobPdf($karta);
        $tab['panton'] = $this->pantonJobPdf($karta);
        $tab['zadruk'] = $this->zadrukJobPdf($karta);
        $tab['laminat'] = $this->laminatJobPdf($karta);
        $tab['mag'] = $this->magJobPdf($karta);
        $tab['pasek'] = $this->pasekJobPdf($karta);
        $tab['ilesipo'] = $this->ilesipoJobPdf($karta);
        $tab['sipo'] = $this->sipoJobPdf($karta);
        $tab['perso'] = $this->persoJobPdf($karta);
        return $tab;
    }
    
    // MATERIAŁ 
    private function materialJobPdf( $karta = array() )  {
        
        if( $karta['chip'] ) { // karta z chipem - cienki plastik
            return 'CIE<br>CIE';
        }
        return  $this->material_kart['short1'][$karta['a_material']] .
                '<br>' .
                $this->material_kart['short1'][$karta['r_material']];
    }
    // SITO PRZED
    private function siprzedJobPdf( $karta = array() )  {
       
        if( $karta['a_podklad'] ) { 
                if( $karta['a_wybr'] ) { 
                    $siprze = $this->farby_na_sito['short1'][$karta['a_podklad']] . $this->wybranie . '<br>';                    
                } else {
                    $siprze = $this->farby_na_sito['short1'][$karta['a_podklad']] . '<br>';
                }
        } else { 
            $siprze = $this->brak . '<br>';             
        }
        if( $karta['r_podklad'] ) { 
            $siprze .=  $this->farby_na_sito['short1'][$karta['r_podklad']];
            if( $karta['r_wybr'] ) { 
                $siprze .= $this->wybranie;                    
            } 
        } else { 
            $siprze .= $this->brak;             
        }
        
        return $siprze;
    }
    //CMYK
    private function cmykJobPdf( $karta = array() )  {
        
        return
            $this->cmyk['C'][$karta['a_c']].
		$this->cmyk['M'][$karta['a_m']].
		$this->cmyk['Y'][$karta['a_y']].
		$this->cmyk['K'][$karta['a_k']].'<br>'.
		$this->cmyk['C'][$karta['r_c']].
		$this->cmyk['M'][$karta['r_m']].
		$this->cmyk['Y'][$karta['r_y']].
		$this->cmyk['K'][$karta['r_k']];
        
    }
    //Pantony
    private function pantonJobPdf( $karta = array() )  {
        
        if( $karta['a_pant'] ) {
            $markup = $karta['a_pant'] . '<br>';
        } else {
            $markup = $this->brak . '<br>';
        }
        if( $karta['r_pant'] ) {
            $markup .= $karta['r_pant'];
        } else {
            $markup .= $this->brak;
        }
        return $markup;
    }
    // ZADRUK Z SITA (po ofsecie a przed laminacją)
    private function zadrukJobPdf( $karta = array() )  {
        
        if( $karta['a_zadruk'] ) { 
                $markup =  $this->farby_na_sito['short1'][$karta['a_zadruk']] . '<br>';
        } else { 
            $markup = $this->brak .'<br>';             
        }
        if( $karta['r_zadruk'] ) { 
                $markup .=  $this->farby_na_sito['short1'][$karta['r_zadruk']];
        } else { 
            $markup .= $this->brak;             
        }        
        return $markup;
    }
    // LAMINAT
    private function laminatJobPdf( $karta = array() )  {
        
        return  $this->laminat['short1'][$karta['a_lam']] .
                '<br>' .
                $this->laminat['short1'][$karta['r_lam']];        
    }
    // Pasek magnetyczny
    private function magJobPdf( $karta = array() )  {
        
        if($karta['mag']) {
            return $this->mag['short2'][$karta['mag']];
        } else {
            return $this->brak;
        }
    }
    // PASEK do podpisu
    private function pasekJobPdf( $karta = array() )  {
        
        if( $karta['a_podpis'] ) { 
                $markup =  $this->pasek['short1'][$karta['a_podpis']] . '<br>';
        } else { 
            $markup = $this->brak .'<br>';             
        }
        if( $karta['r_podpis'] ) { 
                $markup .=  $this->pasek['short1'][$karta['r_podpis']];
        } else { 
            $markup .= $this->brak;             
        }        
        return $markup;
    }
    // ile max jest opcji sita "po" w karcie
    private function ilesipoJobPdf( $karta = array() ) {
        
        $ile_a = 0;                 
        if( $karta['a_lakblys'] ) { $ile_a++; }
        if( $karta['a_lakpuch'] ) { $ile_a++; }
        if( $karta['a_zdrapka'] ) { $ile_a++; }
        
        $ile_r = 0;                 
        if( $karta['r_lakblys'] ) { $ile_r++; }
        if( $karta['r_lakpuch'] ) { $ile_r++; }
        if( $karta['r_zdrapka'] ) { $ile_r++; }
        
        if( $ile_a > $ile_r ) {  return $ile_a; } else { return $ile_r; }        
    }
    
    // Sito po
    private function sipoJobPdf( $karta = array() )  {
        
        if( $karta['a_zdrapka'] || $karta['r_zdrapka'] || $karta['a_lakpuch'] ||
            $karta['r_lakpuch'] || $karta['a_lakblys'] || $karta['r_lakblys'] ) {
            
            $a = $this->sipo['short2']['lbly'][$karta['a_lakblys']];
            if( $a != null && $karta['a_lakpuch']) { $a .= '+'; }
            $a .= $this->sipo['short2']['lpuch'][$karta['a_lakpuch']];
            if( $a != null && $karta['a_zdrapka']) { $a .= '+'; }
            $a .= $this->sipo['short2']['zdra'][$karta['a_zdrapka']];
            if( $a ==  null ) { $a = $this->brak; }            
            $a .= '<br>';
            $r = $this->sipo['short2']['lbly'][$karta['r_lakblys']];
            if( $r != null && $karta['r_lakpuch']) { $r .= '+'; }
            $r .= $this->sipo['short2']['lpuch'][$karta['r_lakpuch']];
            if( $r != null && $karta['r_zdrapka']) { $r .= '+'; }
            $r .= $this->sipo['short2']['zdra'][$karta['r_zdrapka']];
            if( $r ==  null ) { $r = $this->brak;} 
            $sipo = $a . $r;
        } else { 
            $sipo = $this->brak . '<br>' . $this->brak; 
        }
        return $sipo;
    }
    
    // Perso
    private function persoJobPdf( $karta = array() )  {
        
        if($karta['isperso']) {
            return $this->bigyes;
        } else {
           return $this->brak; 
        }
    }
}


