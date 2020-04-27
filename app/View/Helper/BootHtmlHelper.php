<?php
/**
 * Html things for Bootstrap 3 layouts
 *
 * @author dexter
 */

App::uses('AppHelper', 'View/Helper');

class BootHtmlHelper extends AppHelper {
    
    public $helpers = array('Html', 'Math');
    
    public function glyphLink( $glyphname = null, $kontroler = null, $akcja = null, $id = null ) {
    /* 
     * $glyphname - nazwa boot ikonki
     * $kontroler - nazwa kontrolera
     *   $akcja - akcja kontrolera 
   */
        if( $id != null ) {
            $opcje = array( 'controller' => $kontroler, 'action' => $akcja, $id);
        } else {
            $opcje = array( 'controller' => $kontroler, 'action' => $akcja );
        }
        return $this->Html->link(
            '<span class="' . $glyphname . '" aria-hidden="true"></span>',
            $opcje,
            array( 'escape' => false, 'class' => 'glyph')
        );
    }
    
    public function tableOfOrders4Customer( $zamowienia = array(), $inicjaly = array() ) {
        
        $rows = array(); $i = 0; $naklad = 0; $ile = count($zamowienia);
        
        for( $i = $ile-1; $i >= 0; $i--) {
            $order = $zamowienia[$i];
            $rows[] = array(
                $i+1,
                $this->orderNrLink( $order['Order']['id'], $order['Order']['nr'], $order['User']['inic']),
                $this->cardsDropdownDiv($naklad, $order['Card']),
                //$this->Math->tys($naklad),
                array( $this->Math->tys($naklad), array('class' => 'text-right')),
                array( $this->Math->md($order['Order']['stop_day']), array('class' => 'text-center')),                
                $this->status_zamow($order['Order']['status'])
            );
        }
        //array( $inicjaly => array('class' => 'terminx'))
        $naglowek = $this->Html->tableHeaders(array(
            array( '&Sigma; = '.$ile => array('class' => 'col-md-1')),
            array( 'Numer' => array('class' => 'col-md-1')),
            array( 'Karty' => array('class' => 'col-md-6')),
            array( 'Nakład' => array('class' => 'col-md-1 text-right')),            
            array( 'Termin' => array('class' => 'col-md-2 text-center')),
            array( 'Status' => array('class' => 'col-md-1'))            
        ));
        $body = $this->Html->tableCells( $rows );
        return '<table class="table table-striped table-hover table-condensed">' . $naglowek . $body . '</table>';
    }
    
    public function tableOfCards4Customer( $karty = array(), $inicjaly = array() ) {
     
        $rows = array(); $i = 0; $ile = count( $karty );
        for($i = $ile - 1;  $i >= 0; $i-- ) {
            $card = $karty[$i];
            $inic = null;
            if( array_key_exists( $card['Order']['user_id'], $inicjaly) ) {
                $inic = $inicjaly[$card['Order']['user_id']];
            }
            $rows[] = array(
                $i+1,
                $this->cardLink( $card['Card']['id'], $card['Card']['name']),
                array( $this->Math->tys($card['Card']['quantity']), array('class' => 'text-right')),                
                array( $this->orderNrLink(
                                $card['Order']['id'],
                                $card['Order']['nr'],
                                $inic
                        ),
                        array('class' => 'text-right')
                ),                
                array( $this->jobNrLink( $card['Job']['id'], $card['Job']['nr']), array('class' => 'text-right')),                                
                array( $this->Math->md($card['Order']['stop_day'], true), array('class' => 'text-center')),
                $this->statusOfCard($card['Card']['status'])
            );
        } 
        
        $naglowek = $this->Html->tableHeaders(array( 
            array( '&Sigma; = '. $ile => array('class' => 'col-md-1')),
            array( 'Nazwa karty' => array('class' => 'col-md-6')),            
            array( 'Ilość' => array('class' => 'col-md-1 text-right')),            
            array( 'Handlowe' => array('class' => 'col-md-1 text-right')),
            array( 'Produkc.' => array('class' => 'col-md-1 text-right')),            
            array( 'Termin' => array('class' => 'col-md-1 text-center')),
            array( 'Status' => array('class' => 'col-md-1'))
        ));
        $body = $this->Html->tableCells( $rows );
        return '<table class="table table-striped table-hover table-condensed">' . $naglowek . $body . '</table>';
    }
    
    private function cardsDropdownDiv( &$ilosc, $karty = array() ) {
        // przygotowuje html 4 drpdown oraz zlicza nam nakład
        $ile = count($karty); 
        if( $ile > 1 ) {
            $ilosc = 0;
            $markup =   '<div class="dropdown">' .
                            '<a class="dropdown-toggle" data-toggle="dropdown" href="#">' .
                                '<strong>' . $ile . '</strong><span class="caret"></span>' .
                            '</a>';
            $ul = '<ul class="dropdown-menu">';
            foreach( $karty as $karta ) {
                $ul .= '<li>' . $this->cardLink( $karta['id'], $karta['name'] ) . '</li>';
                $ilosc += $karta['quantity'];
            }
            $ul .= '</ul>';
            $markup .= $ul . '</div>';
            return $markup;
        } else {
            $ilosc = $karty[0]['quantity'];
            return $this->cardLink( $karty[0]['id'], $karty[0]['name']);
        }
    }
    
    // chcemy ładny link do edycji klienta
    public function customerEditLink(
            $id = 1,            // id klienta
            $nazwa = '?????' ) {  // nazwa klienta

        return $this->Html->link(
                $nazwa,
                array(
                    'controller' => 'customers',
                    'action' => 'edit', $id )); 
    }
    
    // chcemy ładny link do edycji klienta z glyph - ikonką
    public function customerEditGlyph( $id = 1 ) {
        return $this->glyphLink('glyphicon glyphicon-edit', 'klienci', 'edytuj', $id);
    }
    
    // chcemy ładny link z bazowego numeru zamówienia
    private function orderNrLink(
            $id = 1,            // order_id
            $bnr = 0,           // numer zamówienia w formacie bazy danych
            $inic = null  ) {  // inicjały użytkownika  

        if( $bnr ) { // jak mamy jakiś nr
            $nrTxt = $this->bnrToNrh( $bnr, $inic );
        } else { // nie, to wyświetlamy po prostu id
            $nrTxt = "$id (id)";
        }
        
        return $this->Html->link( $nrTxt, [
                'controller' => 'orders',
                'action' => 'view', $id ],
                ['escape' => false, 'target' => '_blank']); 
    }
    
    // chcemy ładny link z bazowego numeru zlecenia
    private function jobNrLink(
            $id = 1,            // job_id
            $bnr = 0 ) {        // numer zlecenia w formacie bazy danych
              

        return $this->Html->link(
                $this->bnrToNrj( $bnr ),
                array(
                    'controller' => 'jobs',
                    'action' => 'view', $id ),
                array('escape' => false, 'target' => '_blank')); 
    }

    // chcemy ładny link do karty
    private function cardLink(
            $id = 1,    // card_id
            $name = null,      // card_name
            $blank = true) {   // target='_blank'
        
        if( $blank ) {
            $options = array( 'target' => '_blank');
        } else {
            $options = array();
        }
        return $this->Html->link(
                $name,
                array(
                    'controller' => 'cards',
                    'action' => 'view', $id 
                ),
                $options); 
    }

    // convert base nr to nrh - numer handlowego v2
    private function bnrToNrh( $bnr = null, $inicjaly = null ) {

        if($bnr && $bnr > BASE_NR) {                        
            if( $inicjaly )  {
               return    '<strong>' . (int)substr((int)$bnr,2) . '</strong>' . 
                         '/' . substr((int)$bnr,0,2) . ' ' . $inicjaly;                    
            }
            else { 
               return '<strong>' . (int)substr((int)$bnr,2) . '</strong>' .
                       '/' . substr((int)$bnr,0,2) . ' H';                   
            }
        } else
            { return $bnr; }
    }
    
    // convert base nr to nrj - numer job'a v2
    private function bnrToNrj( $bnr = null ) {

            if($bnr && $bnr > BASE_NR) {
                return '<strong>' . (int)substr((int)$bnr,2) . '</strong>' .
                        '/' . substr((int)$bnr,0,2);
            } else
                { return $bnr; }
    }
    
    /*
     *  Chcemy link do pliku css z możliwym parametrem
     */
    
    public function css( 
            $path = array(), // jak w oryginalnej
            $time_par = false) { // jeżeli true, metoda generuje link z timestamp
        
        if( $time_par && !empty($path) ) {
            $retlnk = null; $time = time();
            foreach( $path as $prm) {
                $href = $this->webroot . CSS_URL . $prm . '.css?v=' . $time;  
                $retlnk .= '<link rel="stylesheet" type="text/css" href="' . $href . '" />';
            }
            return $retlnk;
           // return '<link rel="stylesheet" type="text/css" href="' . $href . '" />';
           // '<link rel="stylesheet" type="text/css" href="/SKP/2x/css/boot/core.css?v=29042200" />';
        }
        return $this->Html->css($path);
    }
    
    
}
