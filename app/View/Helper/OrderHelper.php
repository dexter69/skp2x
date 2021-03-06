<?php
/**
 * Dla views związanych z Order */
App::uses('AppHelper', 'View/Helper');

class OrderHelper extends AppHelper {

    public $helpers = ['Ma', 'Html', 'Form'];

    /**
     * Sprawdzamy $txt2check. Jeżeli zawiera tekst otoczony nawiasami klamrowymi,
     * czyli np. { jakiś tekst }, to go "wyciąga". Zwraca tablicę. W kluczu 'curly'
     * mamy mamy tekst, który był pomiędzy nawiasami. W kluczu rest mamy cały,
     * pozostały tekst (pozbiawiony części z nawiasami klamrowymi).  */

    public function findCurly( $txt2check = null ) {

        $startChr = "{"; $stopChr = "}";
        $start = strpos($txt2check, $startChr);
        $stop = strpos($txt2check, $stopChr);
        // Default value if there is no txt in curly brackets
        $response = [
            'curly' => false, 
            'rest' => $txt2check // Jak nie ma przypominajki, to cały tekst do rest
            ,'start' => !$start,'stop' => !$stop, 'weAreHere' => 0
        ];

        if( !($start === false || $stop === false) ) {
            $response['weAreHere'] =1;
            $response['curly'] = trim(substr($txt2check, $start+1, $stop-$start-1)); 
            $rest = trim(substr($txt2check, 0, $start) . substr($txt2check, $stop+1));
            // Pozbywamy się ew. powstałych podwójnych zakónczeń linii, na wypadek Windows i Linux
            $rest = str_replace("\r\n\r\n","\n",  $rest ); // Vindovs  
            $response['rest'] = str_replace("\n\n","\n",  $rest ); // Linux
        }
        
        return $response;
    }

    // All data needed foor displaying card list in thorder
    // $coism mówi czy zalogowany użytkownik może otwierać zamówienia w trybie serwisowym
    public function cardsRelated( $order = [], $evcontrol, $coism = false ) {

        // Jezeli użytkownik może zmieniać status kart, to musimy nadać odpowiednią klasę        
        $ta_klasa = "card_status_fix";
        $ta_klasa .= ( $order['Order']['statusKartyMoznaModyfikowac'] ? " clickable" : "");
        $extraTh = '';
        if (!empty($order['Card']) && $evcontrol['bcontr'][push4checking]) {            
            $extraTh = '<th class="card_dpcheck_fix">'.'D'.'</th>'.'<th class="card_dpcheck_fix">'.'P'.'</th>';	            
        }
        $tbody = $this->tableOfCardsInTheOrder( $order, $evcontrol);        
        
        $showTheServo = SERVO_NIE; // Nie pokazujemy żadnego info o servo
        // Zamówienie zawiera przynajmniej jedną kartę (projekt),         
        if( $tbody['isleft'] ) {  // dla której (którego) jest coś na magazynie
            // Zamówienie jest zamknięte i zalogowany może otwierać takie zamówienia
            if( $order['Order']['status'] == KONEC && $coism ) {
                $showTheServo = SERVO_CLI; // pokazujemy i jest klikalne
            } else { // tylko pokazujemy
                $showTheServo = SERVO_VIS; // pokazujemy tylko
            }            
        }
        return [
            'viewHeader' => $this->Ma->viewheader('KARTY', array('class' => 'margin02')),
            'ta_klasa' => $ta_klasa,
            'extraTh' => $extraTh,
            'html' => $tbody['html'], // html części tabeli
            'sigma' => $tbody['sigma'],
            'isperso' => $tbody['isperso'],
            'isleft' => $tbody['isleft'],
            'karty' => $tbody['karty'],
            'showServo' => $showTheServo // czy pokazać (i jak) komponent do otwierania serwisowego
        ];
    }

    private function tableOfCardsInTheOrder( $order = [], $evcontrol = [])  {

        $cards = $order['Card'];
        $karty = []; $k=0; $sigma = 0; $trs = []; $isleft=false;
        // true - oznacza, że zamówienie zawiera przynajmniej jedną kartę z perso
        $orderIsPerso = false;
        foreach ( $cards as $card ) {
            $cells = [];
            $karty[ $card['id'] ]= $card['name'];
            $sigma += $card['quantity'];

            $cells[] = [$card['id'], ['class' => 'card_id_fix']];

            $cells[] = $this->Html->link($card['name'], ['controller' => 'cards', 'action' => 'view', $card['id']], ['title' => $card['name']]);

            $span = "";
            if( $card['isperso'] ) {
                $span = '<span class="perso">P</span>';
                $orderIsPerso = true;
            }
            //$span = $card['isperso'] ? '<span class="perso">P</span>' : "";            
            $cells[] = [ $span, ['class' => 'card_opcje_fix']];

            $link = "";
            if( $card['job_nr'] ) {
                $link = $this->Html->link(
                    $this->bnr2nrj($card['job_nr'], null),
                    ['controller' => 'jobs', 'action' => 'view', $card['job_id'] ],
                    ['escape' => false]
                );
            }
            $cells[] = [ $link, ['class' => 'card_zlec_fix']];

            $left = "";            
            if( $card['left'] ) {
                $isleft = true;
                $left = "({$this->Ma->tys($card['left'])})";                
            }

            $cells[] = [ $this->Ma->tys($card['quantity']), ['class' => 'card_ilosc_fix']];

            $cells[] = [ $left, ['class' => 'card_ilosc_fix_mag']];
            
            // cena - chcemy, że gdy jest 0, to by program wypisywał "UWAGI"
            $cenka = ( $card['price'] == 0 ? 'UWAGI' : $this->Ma->colon($card['price']));
            $cells[] = [ $cenka, ['class' => 'card_cena_fix']];

            if( $card['status'] == PRIV && $order['Order']['id'] ) {
                $status = 'ZAŁĄCZONA';
            } else {
                $status = $this->Ma->status_karty($card['status']);
            }
            $cells[] = [ $status, ['class' => 'card_status_fix']];		
            
            if( $evcontrol['bcontr'][push4checking] ) {
                $dtpper = $this->dtpPerCheckBoxes( $card, $k++ );
                $cells[] = [ $dtpper['dtp'], ['class' => 'card_dpcheck_fix']];	
                $cells[] = [ $dtpper['per'], ['class' => 'card_dpcheck_fix']];	
            }
            
            $trs[] = $cells;
        }

        return [
            'html' => $this->Html->tableCells($trs),
            'sigma' => $sigma,
            'isperso' => $orderIsPerso,
            'isleft' => $isleft,
            'karty' => $karty
        ];
		
    }
    
    private function dtpPerCheckBoxes( $card, $ind ) {

        $d_checked = $p_checked = false;
        switch( $card['status'] ) {						
            case DNO:
            case DNOPOK:
            case W4D:
            case W4DPOK:
                $d_checked = true;
            break;
            case W4PDOK:
            case DOKPNO:
                $p_checked = true;
            break;
            case W4DPNO:
            case W4DP:
            case W4PDNO:
            case DNOPNO: $d_checked = $p_checked = true;
            break;
        }
        $dtp =  $this->Form->input('ard.'.$ind.'.D', array(
            'type' => 'checkbox',
            'checked'=> $d_checked,            
            'label' => false,
            'div' => false,
            'class' => 'dlajoli',
            'idlike' => 'Card'.$ind.'D',
            'disabled' => $d_checked || $card['status'] == KONEC     
        ));
        $per =  $this->Form->input('ard.'.$ind.'.P', array(
            'type' => 'checkbox',
            'checked'=> $p_checked,
            'label' => false,
            'div' => false,
            'class' => 'dlajoli',
            'idlike' => 'Card'.$ind.'P',
            'disabled' => $card['status'] == KONEC || !$card['isperso'] || $p_checked
        ));
        return [
            'dtp' => $dtp,
            'per' => $per
        ];
    }

    /**
     * Funkcja używana przy konstrukcji elementów do wyświetlania chmurek, dla edytowalnych postów */

    public function constructChmurki($posciki) {    
        /* zkładamy, że $posciki zawiera conajmniej 1 element, nawet jeżeli uż. nic nie napisał,
        to mamy element z pustym stringiem */

        $size = count($posciki);
        $msg_body = "";
        $chmurki = "";
        if(  $size > 1 ) { 
            // Skonstruuj pozostałe, starsze wersje posta i doklej do $msg
            $msg = '<ul class="wersja">';         
            for( $i=1; $i<$size; $i++ ) { 
                $tresc = $posciki[$size - $i];               
                $msg_body .= '<span class="old-msg no-' . $i . '">' . $tresc . '</span>';
                $chmurki .= "<p class='chmurka nr-${i}'>${tresc}</p>";
                $msg .= "<li data-digit='{$i}'><span class='cyferka'>${i}</span></li>";
            }            
            $msg .= "<li class='toli'><span class='tekst'>starsze wersje:</span></li>";            
            $msg .= '</ul>';
            //$msg .= '<p class="ekstra-msgs">' . nl2br($msg_body) . '</p>';
        } else {
            $msg = '';
        }

        $postek0 = nl2br($posciki[0]);
        return [
            'ol' => "<ol class='olevent'><li>${postek0}</li></ol>",
            'msg' => $msg,
            'chmurki' => nl2br($chmurki)
        ];        

    }

}