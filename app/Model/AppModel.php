<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
    public function print_r2($val){ echo '<pre>'; print_r($val); echo  '</pre>';}
    
    /*
     * Etykiety */
    public $etyk_view = array(
        'etykieta' =>   array(
            'options' => array(
                'standa' => 'STANDARD',
                'zakres' => 'STANDARD + ZAKRES',
                //'zpliku' => 'Z PLIKU',
                'nietyp' => 'NIETYPOWA',
                'niebyc' => 'BRAK'
        )),
        'etylang' =>   array( 
            'label' => 'Język etykiety',
            'options' => array(
                'pl' => 'Polski',
                'en' => 'Angielski',
                'de' => 'Niemiecki'
            ),
            'view' => array(
                'pl' => 'polska',
                'en' => 'angielska',
                'de' => 'niemiecka'),
            'cview' => array( // widok klienta
                'pl' => 'polski',
                'en' => 'angielski',
                'de' => 'niemiecki'
            )
        )
    );
    
    //wyświetlanie tekstów o zdarzeniach
    public $eventText = array(
            ZERO => array(
                    '',
                    '','class' => 'zadna'),
            publi => array(
                    'złożył zamówienie',
                    'złożyła zamówienie','class' => 'pom'),
            kor_ok => array(
                    'zatwierdził zamówienie',
                    'zatwierdziła zamówienie','class' => 'ziel'),
            kor_no => array(
                    'odrzucił zamówienie',
                    'odrzuciła zamówienie','class' => 'czer'),
            d_ok => array(
                    'zatwierdził kartę: ',
                    'zatwierdziła kartę: ','class' => 'ziel'),
            d_no => array(
                    'odrzucił kartę: ',
                    'odrzuciła kartę: ','class' => 'czer'),
            p_ok => array(
                    'zatwierdził perso: ',
                    'zatwierdziła perso: ','class' => 'ziel'),
            p_no => array(
                    'odrzucił perso: ',
                    'odrzuciła perso: ','class' => 'czer'),
            p_ov => array(
                    'zakończył personalizację: ',
                    'zakończyła personalizację: ','class' => 'ziel'),
        h_ov => array(
                'zakończył hotstamping: ',
                'zakończyła hotstamping: ','class' => 'ziel'),
            put_kom => array(
                    'napisał',
                    'napisała','class' => 'pom'),
            fix_o => array(
                    'poprawił zamówienie',
                    'poprawiła zamówienie','class' => 'pom'),
            send_o => array(
                    'zakończył zamówienie',
                    'zakończyła zamówienie','class' => 'ziel'),
            unlock_o => array(
                    'odblokował zamówienie',
                    'odblokowała zamówienie','class' => 'pom'),
            unlock_again => array(
                    'zwrócił uzupełnione zamówienie',
                    'zwróciła uzupełnione zamówienie','class' => 'czer'),
            update_o  => array(
                    'uzupełnił zamówienie',
                    'uzupełniła zamówienie','class' => 'pom'),	
            klepnij => array(
                    'zaakceptował uzupełnione zamówienie',
                    'zaakceptowała uzupełnione zamówienie','class' => 'ziel'),	
            push4checking => array(
                    'przekazał do sprawdzenia DTP/P',
                    'przekazała do sprawdzenia DTP/P','class' => 'pom'),
            odemknij => array(
                    'otworzył zamówienie',
                    'otworzyła zamówienie','class' => 'pom'),
            eJPUBLI => array(
                    'złożył zlecenie',
                    'złożyła zlecenie','class' => 'pom'),
            eJKOM => array(
                    'napisał',
                    'napisała','class' => 'pom'),
            eJ_FILE1 => array(
                    'załączył pliki',
                    'załączyła pliki','class' => 'pom'),
            eJ_FILE2 => array(
                    'załączył pliki',
                    'załączyła pliki','class' => 'pom'),
            eJ_FILE3 => array(
                    'poprawił',
                    'poprawiła','class' => 'pom'),
            eJF_BACK => array(
                    'odrzucił pliki',
                    'odrzuciła pliki','class' => 'czer'),
            eJF_OK => array(
                    'zaakceptował pliki',
                    'zaakceptowała pliki','class' => 'ziel'),
            eJ_KOR2B => array(
                    'poprawił zlecenie',
                    'poprawiła zlecenie','class' => 'pom'),
            eJ_KOR2DTP => array(
                    'odrzucił pliki',
                    'odrzuciła pliki','class' => 'czer'),
            ePUSH2B => array(
                    'zatwierdził pliki',
                    'zatwierdziła pliki','class' => 'ziel'),
            eJ_B2KOR => array(
                    'zwrócił na biurko',
                    'zwróciła na biurko','class' => 'czer'),
            eJ_COF2KOR => array(
                    'zwrócił na biurko',
                    'zwróciła na biurko','class' => 'czer'),
            eJ_COF2DTP => array(
                    'zwrócił do DTP',
                    'zwróciła do DTP','class' => 'czer'),
            eJB_UNPAUSE => array(
                    'zaakceptował',
                    'zaakceptowała','class' => 'ziel'),
            eJ_KBACK =>	 array(
                    'poprawił',
                    'poprawiła','class' => 'pom'),
            eJ_DBACK =>	 array(
                    'poprawił',
                    'poprawiła','class' => 'pom'),
            eB_REJ => array(
                    'zwrócił',
                    'zwróciła','class' => 'czer'),
            eJ_B2DTP => array(
                    'zwrócił do DTP',
                    'zwróciła do DTP','class' => 'czer'),
            eJ_ACC => array(
                    'zatwierdził',
                    'zatwierdziła','class' => 'ziel'),
            // zdarzenia przedpłaty
            pp_red => array(
                    'BRAK WPŁATY',
                    'BRAK WPŁATY','class' => 'czer'),
            pp_ora => array(
                    'JEST POTWIERDZENIE',
                    'JEST POTWIERDZENIE','class' => 'pom'),
            pp_gre => array(
                    'JEST WPŁATA',
                    'JEST WPŁATA','class' => 'ziel')

    );
    
    // Dane do wysłania e-maila
    public $e_data = array();
    
    /* Przygotuj tablicę z odbiorcami e-maila
     * $eventtab - tablica z danymi dla mozdelu Event (z requestdata) */
    public function prepEmailData( $eventtab = array() ) {
        
        if(array_key_exists(0, $eventtab)) { // znaczy wersja dla hasMany
            $eventtab = $eventtab[0]; // na lokalne potrzeby
        }
        $this->tematTrescLink($eventtab);    
        
        foreach( $this->e_data['value']['Event'] as $ewent ) {
                $uids[$ewent['user_id']] = 1; //przypisz na razie cokolwiek	
        }
        if( $eventtab['job_id'] ) { //zlecenie, trza też handlowcom wyslac
            foreach( $this->e_data['value']['Card'] as $karta ) {
                $uids[$karta['user_id']] = 1; } //przypisz na razie cokolwiek					
        }
        $uids[4] = 1; // Jola zawsze dostaje			
        unset($uids[AuthComponent::user('id')]); // generujący zdarzenie nie dostaje maila
        $uids[1] = 1; // Darek zawsze dostaje, nawet jak sam napisze                        
        $tab = array();
        foreach( $uids as $key => $wartosc) { $tab[] = $key; }
        $this->ludzikoza( $tab, $eventtab );
    }
    
    private function ludzikoza( $tab, $eventtab ) {
        
        $ludziki = $this->User->find('all', array(
                'conditions' => array('User.id' => $tab),
                'recursive' => 0
        ));
        
        $odbiorcy = array();
        foreach( $ludziki as $ludz) {
            if( $ludz['User']['enotif'] != null ) {
                $odbiorcy[] = $ludz['User']['enotif']; }
        }
        if( $eventtab['co'] == p_ov ) { // w wypadku zakończenia perso, dodatkowo dostaje Krysia
            $odbiorcy[] = 'info@polskiekarty.pl';
        }
        // Frank nie chce tych powiadomień...
        //if( $eventtab['co'] == p_ov || $eventtab['co'] == send_o ) {
        if( in_array($eventtab['co'], array(p_ov, send_o)) || $eventtab['post'] == NULL ) {
            $klucz = array_search('grafik@polskiekarty.pl',  $odbiorcy);
            if( $klucz != false ) {
                unset( $odbiorcy[$klucz] );
            }
        }
        $this->e_data['odbiorcy'] = implode(" ", $odbiorcy);
    }
    
    /* Przygotuj temat, treść i link e-maila
     * * $eventtab - tablica z danymi dla modelu Event (z requestdata) */
    private function tematTrescLink( $eventtab = array() ) {
        
        
        if( $eventtab['order_id'] ) { // do handlowego
            if( isset($eventtab['noevent']) ) { // robione z innego modelu niż Event
                $this->e_data['value'] = $this->find('first', array(
                    'conditions' => array('Order.id' => $eventtab['order_id'])));
            } else {
                $this->e_data['value'] = $this->Order->find('first', array(
                    'conditions' => array('Order.id' => $eventtab['order_id'])));
            }            
            $this->e_data['temat'] = 'ZAM ' . $this->bnr2nrh2($this->e_data['value']['Order']['nr'], $this->e_data['value']['User']['inic'],false);
            $this->e_data['linktab'] = array('controller' => 'orders', 'action' => 'view', $eventtab['order_id']); }
        else { // do produkcyjnego
                $this->e_data['value'] = $this->Job->find('first', array(
                    'conditions' => array('Job.id' => $eventtab['job_id'])));
                $this->e_data['temat'] = 'ZLE ' .  $this->bnr2nrj2($this->e_data['value']['Job']['nr'],$this->e_data['value']['User']['inic'],false);
                $this->e_data['linktab'] = array('controller' => 'jobs', 'action' => 'view', $eventtab['job_id']); 
        }
        
        $this->e_data['temat'] .=   ', ' . AuthComponent::user('name') . ' ' .
                    $this->eventText[$eventtab['co']][AuthComponent::user('k')];
        
        if($eventtab['card_id']) {
            if( $eventtab['co'] == put_kom ) { $this->e_data['temat'] .= ' odnośnie karty:'; }
            foreach( $this->e_data['value']['Card'] as $karta ) {
                if( $karta['id'] == $eventtab['card_id'] ) { $this->e_data['temat'] .= ' ' . $karta['name']; }
            }
        } 
        $this->e_data['tresc'] = $eventtab['post'];
    }
    
    // convert base nr to nrj - numer job'a
    public function bnr2nrj2($bnr = null, $inicjaly = null, $ishtml = true, $sepyearchar = '/') {

            if($bnr && $bnr > BASE_NR) {
                if( $ishtml ) {
                    $startspan = '<span class="ordernr">';
                    $stopspan = '</span>';
                } else {
                    $startspan = $stopspan = null; }                
                return (int)substr((int)$bnr,2).$startspan.$sepyearchar.substr((int)$bnr,0,2).$stopspan;
            }
            return $bnr;
    }
    
    /*  Konwertuje numer składający się wyłącznie z cyfr (a więc bez roku) na nr 
        w formacie bazy danych. Domyślnie rok bieżący lub zmodyfkikowany ofsetem */
    public function digitOnlyNr2dbNr( $nr = null, $ofset = 0 ) {
        
        $nrs = (string)$nr;        
        $year = date("y") + $ofset;
        return $year . substr(BASE_ZERO, strlen($nrs)) . $nrs;
    }
    
    // convert base nr to nrh - numer handlowego
    public function bnr2nrh2($bnr = null, $inicjaly = null, $ishtml = true, $sepyearchar = '/') {

        if($bnr && $bnr > BASE_NR) {
            if( $ishtml ) {
                $startspan = '<span class="ordernr">';
                $stopspan = '</span>';
            } else {
                $startspan = $stopspan = null;
            }
            if( $inicjaly ) {
                return (int)substr((int)$bnr,2).$startspan.$sepyearchar.substr((int)$bnr,0,2).' '.$inicjaly.$stopspan; }
            else {
                return (int)substr((int)$bnr,2).$startspan.$sepyearchar.substr((int)$bnr,0,2).' H'.$stopspan; }
        }  
        return $bnr; 
    }	
    
}
