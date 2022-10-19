<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 * @property User $User
 * @property Order $Order
 * @property Job $Job
 * @property Card $Card
 */
class Event extends AppModel
{

        public $code = 0;
        public $msg = null;

        private $zdarzeniaDlaPerso = [ // interesując nas zdarzenia
                fix_o, servpubli
                //    ,d_no, d_ok, put_kom,  unlock_o, update_o, unlock_again, klepnij,
                //    push4checking, servopen, kor_no, kor_ok
        ];

        private function check_other_cards($eventarr = array())
        {

                $wynik = array('checked' => true, 'are_ok' => true, 'order_status' => null);
                if ($eventarr['order_id']) { //

                        $result = $this->Order->zamkart_statusy_only($eventarr['order_id']);

                        $wynik['result'] = $result;
                        //echo '<pre>'; print_r($result); echo '</pre>';
                        if (!empty($result['Order']))
                                $wynik['order_status'] = $result['Order']['status'];
                        foreach ($result['Card'] as $card) {

                                $wynik[$card['id']] = $card['status'];
                                if ($card['id'] != $eventarr['card_id']) {
                                        if (in_array($card['status'], array(W4D, W4DP, W4DPNO, W4DPOK, W4PDNO, W4PDOK))) {
                                                $wynik['checked'] = false;
                                                $wynik['are_ok'] = false;
                                                //return $wynik;
                                        }
                                        if ($card['status'] != DOK && $card['status'] != DOKPOK)
                                                $wynik['are_ok'] = false;
                                }
                        }
                }
                return $wynik;
        }


        private function zamknijLubOtworz($id = null, $otworz = false)
        {
                // gdy otworz == true, to znaczy, że mamy otworzyć

                $wynik = array('ok' => false, 'msg' => '...');
                if ($id != null) {
                        $things2end = $this->orderAndCards2close($id, $otworz);
                        $jobyaffected = $this->jobyToOpenOrClose($things2end, $otworz);
                        $wynik = $this->try2saveIt($things2end, $jobyaffected);
                } else {
                        $wynik = array('ok' => false, 'msg' => 'id zamówienia podane null');
                }

                return $wynik;
        }

        private function orderAndCards2close($id = null, $otworz = false)
        { // id order'a

                $opcje = array(
                        'conditions' => array('Order.id' => $id),
                        'fields' => array('Order.id', 'Order.status'),
                        'recursive' => 1
                );
                $rez = $this->Order->find('first', $opcje);
                $things2end['Order'] = $rez['Order'];
                $things2end['Order']['status'] = $otworz ? O_ACC : KONEC;

                $statusKarty = $otworz ? W_PROD : KONEC;
                foreach ($rez['Card'] as $karta) {
                        $things2end['Card'][] = array('id' => $karta['id'], 'job_id' => $karta['job_id'], 'status' => $statusKarty);
                        $tmp[$karta['job_id']] = true;
                }
                foreach ($tmp as $key => $value) $jobtab[] = $key;
                $things2end['jobtab'] = $jobtab;
                return $things2end;
        }

        private function jobyToOpenOrClose($things2end, $otworz = false)
        {

                $opcje = array(
                        'conditions' => array('Job.id' => $things2end['jobtab']),
                        'fields' => array('Job.id', 'Job.status'),
                        'recursive' => 1
                );
                $joby = $this->Job->find('all', $opcje);

                /* Nie wszystkie joby są do zakończenia, bo mogą zawierać karty z innych (niezakańczanych)
               handlowych - dlatego musimy znaleźć te joby, które trzeba zakończyć.
             * Podobnie - nie wszystkie joby trza otwierać, bo niektóre mogą być nie zamknięte
             */
                $jobyaffected = array();
                foreach ($joby as $row) { //
                        $tenjob = $this->examTheJob($things2end['Order']['id'], $row, $otworz);
                        if ($tenjob) {
                                $row['Job']['status'] = $otworz ? sJ_PROD : KONEC;
                                $jobyaffected[] = $row['Job'];
                        }
                }
                return $jobyaffected;
        }

        private function examTheJob($order_id, $jobrow, $otworz)
        {

                if ($otworz) { // znaczy - mamy otworzyć job'a
                        if ($jobrow['Job']['status'] != KONEC) {
                                return false;
                        } // ten nie otwieramy
                } else { // czyli zamknąć
                        foreach ($jobrow['Card']  as $kartazjoba) {
                                if ($kartazjoba['order_id'] != $order_id &&  $kartazjoba['status'] != KONEC) {
                                        return false;
                                }
                        }
                }
                return true;
        }

        private function try2saveIt($orderAndCards, $joby)
        {

                $wynik = array('ok' => true, 'msg' => 'ALL gites!');
                unset($orderAndCards['jobtab']); // jest zbędne
                if ($this->Order->saveAssociated($orderAndCards)) {
                        if (!empty($joby)) {
                                if (!$this->Job->saveMany($joby)) {
                                        $wynik = array('ok' => false, 'msg' => 'Nie moge zakończyć zleceń/nia');
                                }
                        }
                } else {
                        $wynik = array('ok' => false, 'msg' => 'Nie moge zakończyć zamówienia id = ' . ['Order']['id']);
                }
                return $wynik;
        }

        private function is_klosing_aktion($eventarr = array())
        {
                /* sprawdzamy, czy ta akcja zamyka pozytywnie sprawdzanie zamówienia,
			czyli czy wszystkie inne karty i/lub zamówienie jest pozytywnie
			zatwierdzone.
			Jeżeli zamyka, to 'konec' => true
		*/

                $orderAndCards = $this->Order->zamkart_statusy_only($eventarr['order_id']);
                if (!empty($orderAndCards)) {
                        $i = 0;
                        $ret = array('konec' => true, 'noerr' => true, 'dane' => $orderAndCards, 'mark' => []);
                        //sprawdzamy wszystkie karty		
                        foreach ($orderAndCards['Card'] as $karta) {
                                $ret['mark'][$karta['id']] = "0";
                                if ($karta['id'] == $eventarr['card_id']) { //czyli było d_ok lub p_ok na TEJ karcie
                                        $ret['mark'][$karta['id']] = "1";
                                        if (
                                                $eventarr['co'] == d_ok && !in_array($karta['status'], array(W4D, W4DPOK)) ||
                                                $eventarr['co'] == p_ok && $karta['status'] != W4PDOK
                                        ) {
                                                // czyli wiadomo już, że to nie zamyka
                                                $ret['konec'] = false;
                                                $ret['mark'][$karta['id']] = "2";
                                                break;
                                        }
                                } else { // inna karta musi być już zatwierdzona, by była to akcja zamykająca
                                        // 1. if( $karta['status'] != DOK && $karta['status'] != DOKPOK ) {
                                        // 2. if( $karta['status'] != DOK && $karta['status'] != DOKPOK && $orderAndCards['Order']['status'] != UZU_CHECK) {
                                        $ret['mark'][$karta['id']] = "3";
                                        if (in_array($karta['status'], array(W4D, W4DP, W4DPOK, W4PDOK))) {
                                                // czyli wiadomo już, że to nie zamyka
                                                $ret['konec'] = false;
                                                $ret['mark'][$karta['id']] = "4";
                                                break;
                                        }
                                }
                                unset($ret['dane']['Card'][$i]['order_id']);
                                // Jakby to była zamykajaca akcja w trybie usupełniania, to przygotowujemy karty.
                                if ($orderAndCards['Order']['status'] == UZU_CHECK) {
                                        if ($ret['dane']['Card'][$i]['remstatus']) { //
                                                $ret['mark'][$karta['id']] .= "-1";
                                                // [!@#$] BYŁO: if( $ret['dane']['Card'][$i]['remstatus'] = CRAZY ) { // CO ZA BŁĄD!!
                                                if ($ret['dane']['Card'][$i]['remstatus'] == CRAZY) { //Wybieg z dołączaniem karty
                                                        $ret['dane']['Card'][$i]['status'] = R2BJ;
                                                        $ret['mark'][$karta['id']] .= "#1";
                                                } else {
                                                        $ret['dane']['Card'][$i]['status'] = $ret['dane']['Card'][$i]['remstatus'];
                                                        $ret['mark'][$karta['id']] .= "#2";
                                                }
                                                $ret['dane']['Card'][$i]['remstatus'] = 0;
                                        } else {
                                                $ret['mark'][$karta['id']] .= "-3";
                                                unset($ret['dane']['Card'][$i]);
                                        }
                                } else {
                                        $ret['mark'][$karta['id']] .= "-2";
                                        $ret['dane']['Card'][$i]['status'] = R2BJ;
                                        unset($ret['dane']['Card'][$i]['remstatus']);
                                }

                                $i++;
                        }
                        // przeszlismy foreach - jeżeli $ret['konec'], to wszystkie kary są klepnięte

                        if ($ret['konec']) { //karty sprawdzone, a co ze zleceniem
                                if ($eventarr['co'] != kor_ok) {
                                        if ($orderAndCards['Order']['status'] != O_FINE && $orderAndCards['Order']['status'] != UZU_CHECK) {
                                                // wszystkie karty ok, akcja na ostatniej karcie, a zamówienie nie klepnięte (lub nie w trybie uzupełniania)
                                                $ret['konec'] = false;
                                        } else {
                                                if ($orderAndCards['Order']['status'] == O_FINE) {
                                                        $ret['dane']['Order']['status'] = O_ACC;
                                                        unset($ret['dane']['Order']['remstatus']);
                                                } else { //znaczy że w trybie uzup
                                                        $ret['dane']['Order']['status'] = $ret['dane']['Order']['remstatus'];
                                                        $ret['dane']['Order']['remstatus'] = 0;
                                                }
                                        }
                                } else
                                        unset($ret['dane']['Order']['remstatus']);
                        }

                        return $ret;
                }
                return array('konec' => false, 'noerr' => false);
        }

        // Ustaw odpowiednie statusy kart, karty niepotrzebne usuń
        private function setUpServoCards(&$karty = [])
        {

                $i = 0;
                foreach ($karty as $karta) {
                        if ($karta['isperso'] && !$karta['pover']) {
                                // czyli jak karta nie jest pover, to znaczy że handlowiec edytował

                                // sumulujemy proces przesyłania do perso do sprawdzenia
                                $karty[$i]['status'] = W4PDOK;
                                $karty[$i]['remstatus'] = W_PROD;

                                // resetujemy starą datę perso (jeżeli by takowa istniała)
                                $karty[$i]['stop_perso'] = NULL;
                        } else {
                                $karty[$i]['status'] = KONEC; // zostawiamy zakończoną                                
                        }
                        unset($karty[$i]['left'], $karty[$i]['pover'], $karty[$i]['isperso']);
                        $i++;
                }
        }

        // Sprawdzamy czy w tablicy z kartami choć jedna ma perso
        private function hasPerso($karty = [])
        {

                foreach ($karty as $karta) {
                        if (array_key_exists('isperso', $karta) && $karta['isperso']) {
                                return true;
                        }
                }
                return false;
        }

        // Czy personalizacja powinna otrzymać powiadomienie?
        private function notifyPerso($co, $karty = [])
        {

                // Jeżeli to jest interesujące nas zdarzenie i choć jedna karta ma perso
                if (in_array($co, $this->zdarzeniaDlaPerso) && $this->hasPerso($karty)) {
                        return true;
                }
                return false;
        }

        // Przygotuj format danych, usuń zbędne itp. i ewentualnie zapisz
        public function prepareData($rqdata = array(), $sav = false)
        {



                function status_kart(&$tableOfCards, $newsta)
                {

                        $i = 0;
                        foreach ($tableOfCards as $karta) {
                                if ($newsta == W4D && $karta['isperso'])
                                        $tableOfCards[$i]['status'] = W4DP;
                                else
                                        $tableOfCards[$i]['status'] = $newsta;
                                unset($tableOfCards[$i++]['isperso']);
                        }
                }

                /**
                 * Sprawdzamy, czy mamy sytuację, gdzie zostały dodane nowe karty/projekty
                 * do już istniejacych. Czyli sytuacja, gdy istnieje już zamówienie z jakimiś
                 * kartami i handlowiec edytując je, dodaje nowe projekty do już istniejących,
                 * czy też kasuje stare i dodaje nowe        */
                function areNewProjectsAdded($tOfCards, $event = publi)
                {

                        if ($event != publi && $event != null) {
                                /* Jezeli mamy do czynienia z publikacją zamówienia, to nie ma sensu testować*/
                                foreach ($tOfCards as $karta) {
                                        if ($karta['status'] == PRIV) {
                                                return true;
                                        }
                                }
                        }
                        return false;
                }

                function smart_status(&$tableOfCards, $akcja = null)
                {

                        if (areNewProjectsAdded($tableOfCards, $akcja)) {
                                $thereAreNewProjects = true;
                                //$oStatus = NOWKA;
                                $oStatus = UZUPED;
                        } else {
                                /* zwracany status zamówienia. Na razie asekuracyjnie ustawiamy UZUPED,
                                gdyż w pierwszym podejsciu dla akcji uzupełniania używamy */
                                $oStatus = UZUPED;
                                $thereAreNewProjects = false;
                        }

                        function retCorrectW4Status($isPerso = false, $checked = false)
                        {

                                if ($isPerso) {
                                        if ($checked) {
                                                return DOKPOK;
                                        }
                                        return W4DP;
                                }
                                if ($checked) {
                                        return DOK;
                                }
                                return W4D;
                        }

                        $i = 0;
                        foreach ($tableOfCards as $karta) {

                                switch ($karta['status']) {
                                        case PRIV: // przypadek, gdy nowe karty zostały dodane, już po złożeniu zamówienia
                                                $tableOfCards[$i]['status'] = retCorrectW4Status($karta['isperso']);
                                                $tableOfCards[$i]['remstatus'] = CRAZY;  // wybieg, by sobie oznaczyć, ze to dodana karta
                                                break;
                                        case DNO:
                                                $tableOfCards[$i]['status'] = W4D;
                                                break;
                                        case DNOPOK:
                                                $tableOfCards[$i]['status'] = W4DPOK;
                                                break;
                                        case DNOPNO:
                                        case W4PDNO:
                                        case W4DPNO:
                                                $tableOfCards[$i]['status'] = W4DP;
                                                break;
                                        case DOKPNO:
                                                $tableOfCards[$i]['status'] = W4PDOK;
                                                break;
                                }
                                unset($tableOfCards[$i++]['isperso']);
                                // To unset musi być, podobnie jak w status_kart, bo save Associated
                                // nie może zapisac, prawdop coś z walidacją, czy cóś
                        }
                        return $oStatus;
                }

                if (array_key_exists(0, $rqdata['Card'])) { // znaczy wersja dla hasMany    
                        $karty = $rqdata['Card']; // Zapisujemy pierwotną tablicę z kartami 
                } else { // hasOne, np. zdarzenie dotyczące karty i musimy poraić coby nam dobrze działało
                        $karty[0] = $rqdata['Card'];
                }

                $rqdata['Event']['user_id'] = AuthComponent::user('id');
                $event = $rqdata['Event']['co'];
                /* Mała poprawka w związku ze zmianą sposobu wysyłania e-mail powiadomień 
        if( !array_key_exists('order_id', $rqdata['Event']) ) { } 
        probably no need anymore */

                switch ($event) {

                        case d_ok:
                        case p_ok:
                                $tab = $this->is_klosing_aktion($rqdata['Event']);
                                //$rqdata = $tab;
                                //break;
                                if ($tab['konec']) {
                                        // czyli wszystkie inne karty i zamówienie są klepnęte	
                                        $tab['dane']['Event'] = $rqdata['Event'];
                                        $tab['dane']['tab'] = $tab;
                                        $rqdata = $tab['dane'];
                                } else { // nie jest zamykającą akcją, zajmujemy się tylko tą kartą
                                        if ($tab['noerr']) {
                                                $rqdata['Card']['id'] = $rqdata['Event']['card_id'];
                                                switch ($rqdata['Card']['status']) { //status tej karty
                                                        case W4D:
                                                                $rqdata['Card']['status'] = DOK;
                                                                break;
                                                        case W4DP:
                                                                if ($event == d_ok)
                                                                        $rqdata['Card']['status'] = W4PDOK;
                                                                else
                                                                        $rqdata['Card']['status'] = W4DPOK;
                                                                break;
                                                        case W4DPNO:
                                                                $rqdata['Card']['status'] = DOKPNO;
                                                                break;
                                                        case W4DPOK:
                                                                $rqdata['Card']['status'] = DOKPOK;
                                                                break;
                                                        case W4PDNO:
                                                                $rqdata['Card']['status'] = DNOPOK;
                                                                break;
                                                        case W4PDOK:
                                                                $rqdata['Card']['status'] = DOKPOK;
                                                                break;
                                                }
                                                unset($rqdata['Card']['isperso']);
                                                //$rqdata['dane'] = $tab['dane'];
                                        } else { // coś nie tak, błędy
                                                $rqdata = [];
                                        }
                                }
                                break;

                        case fix_o:
                                $rqdata['Order']['status'] = FIXED;
                                $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                smart_status($rqdata['Card'], $event);
                                break;
                        case update_o:
                                $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                $rqdata['Order']['status'] = smart_status($rqdata['Card'], $event);
                                //unset($rqdata['Card']);                                
                                break;

                        case push4checking: /* Technolog wysłał do sprawdzenia DTP lub/i PERSO.
                                Najpierw sprawdźmy czy nie zapomniał zaklikać kart  */
                                $kliki = 0;
                                $i = 0;
                                foreach ($rqdata['Card'] as $karta) {
                                        switch ($karta['D'] + $karta['P']) {
                                                case 0: // ta karta nas nie obchodzi
                                                        unset($rqdata['Card'][$i]);
                                                        break;
                                                case 1: // ta nas obchodzi
                                                        if (
                                                                $rqdata['Card'][$i]['remstatus'] ||
                                                                $rqdata['Card'][$i]['status'] == W4D ||
                                                                $rqdata['Card'][$i]['status'] == W4DP
                                                        ) { // tzn ze juz ustawialismy
                                                                unset($rqdata['Card'][$i]['remstatus']);
                                                        } else { // trzeba zapamiętać
                                                                $rqdata['Card'][$i]['remstatus'] = $rqdata['Card'][$i]['status'];
                                                        }
                                                        if ($karta['D']) {
                                                                if ($karta['isperso'])
                                                                        $rqdata['Card'][$i]['status'] = W4DPOK;
                                                                else
                                                                        $rqdata['Card'][$i]['status'] = W4D;
                                                        } else {
                                                                $rqdata['Card'][$i]['status'] = W4PDOK;
                                                                $rqdata['Card'][$i]['pover'] = 0;
                                                        }
                                                        unset($rqdata['Card'][$i]['D']);
                                                        unset($rqdata['Card'][$i]['P']);
                                                        unset($rqdata['Card'][$i]['isperso']);
                                                        break;
                                                case 2:
                                                        if ($rqdata['Card'][$i]['remstatus']) // tzn ze juz ustawialismy
                                                                unset($rqdata['Card'][$i]['remstatus']);
                                                        else // trzeba zapamiętać
                                                                $rqdata['Card'][$i]['remstatus'] = $rqdata['Card'][$i]['status'];
                                                        $rqdata['Card'][$i]['status'] = W4DP;
                                                        $rqdata['Card'][$i]['pover'] = 0;
                                                        unset($rqdata['Card'][$i]['D']);
                                                        unset($rqdata['Card'][$i]['P']);
                                                        unset($rqdata['Card'][$i]['isperso']);
                                                        break;
                                        }
                                        $kliki = $kliki + $karta['D'] + $karta['P'];
                                        $i++;
                                }
                                if (!$kliki) {
                                        $this->code = 777;
                                        $this->msg = 'ZAPOMNIAŁAŚ/ŁEŚ ZAZNACZYĆ KARTY';
                                        return false;
                                } else {
                                        $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                        $rqdata['Order']['status'] = UZU_CHECK;
                                }
                                break;



                                //handlowiec opublikował zamówienie
                        case publi:
                                /* sprawdzamy czy to nie jest publikacja po otwarciu serwisowym
                        - czy zamowienie ma jakieś zdarzenia (nowe nie ma) */
                                if ($rqdata['Event']['ile_events']) {
                                        // Zmieniamy zdarzenie, bo to publikacja w trybie serwisowym     
                                        $rqdata['Event']['co'] = $event = servpubli;
                                        // sumulujemy proces przesyłania do perso do sprawdzenia
                                        $rqdata['Order']['status'] = UZU_CHECK;
                                        $rqdata['Order']['remstatus'] = O_ACC;
                                        $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                        // Ustaw odpowiednie statusy kart, karty niepotrzebne usuń
                                        $this->setUpServoCards($rqdata['Card']);
                                } else {
                                        $rqdata['Order']['status'] = NOWKA;
                                        $rqdata['Order']['data_publikacji'] = date('Y-m-d H:i:s');
                                        $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                        status_kart($rqdata['Card'], W4D);
                                }
                                break;

                        case kor_no:
                                $rqdata['Order']['status'] = O_REJ;
                                $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                unset($rqdata['Card']);
                                break;
                        case kor_ok:
                                $tab = $this->is_klosing_aktion($rqdata['Event']);
                                if ($tab['konec']) {
                                        $tab['dane']['Event'] = $rqdata['Event'];
                                        $rqdata = $tab['dane'];
                                        $rqdata['Order']['status'] = O_ACC;
                                } else {
                                        $rqdata['Order']['status'] = O_FINE;
                                        $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                        unset($rqdata['Card']);
                                }
                                break;
                        case d_no:
                                $ocards = $this->check_other_cards($rqdata['Event']);
                                //print_r($ocards);
                                $rqdata['Card']['id'] = $rqdata['Event']['card_id'];
                                switch ($ocards[$rqdata['Card']['id']]) { //status tej karty
                                        case W4D:
                                                $rqdata['Card']['status'] = DNO;
                                                break;
                                        case W4DP:
                                                $rqdata['Card']['status'] = W4PDNO;
                                                break;
                                        case W4DPNO:
                                                $rqdata['Card']['status'] = DNOPNO;
                                                break;
                                        case W4DPOK:
                                                $rqdata['Card']['status'] = DNOPOK;
                                                break;
                                }
                                unset($rqdata['Card']['isperso']);
                                $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                if ($ocards['order_status'] == UZU_CHECK)
                                        $rqdata['Order']['status'] = W4UZUP; //UZU_REJ;
                                else
                                        $rqdata['Order']['status'] = O_REJ;
                                $rqdata['Card'] = array($rqdata['Card']);
                                //$rqdata['ocards'] = $ocards;				
                                break;
                        case p_no:
                                $ocards = $this->check_other_cards($rqdata['Event']);
                                $rqdata['Card']['id'] = $rqdata['Event']['card_id'];
                                switch ($ocards[$rqdata['Card']['id']]) { //status tej karty
                                        case W4DP:
                                                $rqdata['Card']['status'] = W4DPNO;
                                                break;
                                        case W4PDNO:
                                                $rqdata['Card']['status'] = DNOPNO;
                                                break;
                                        case W4PDOK:
                                                $rqdata['Card']['status'] = DOKPNO;
                                                break;
                                }
                                unset($rqdata['Card']['isperso']);
                                $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                if ($ocards['order_status'] == UZU_CHECK)
                                        $rqdata['Order']['status'] = W4UZUP;
                                else
                                        $rqdata['Order']['status'] = O_REJ;
                                $rqdata['Card'] = array($rqdata['Card']);
                                break;
                        case p_ov:
                                $rqdata['Card']['id'] = $rqdata['Event']['card_id'];
                                $rqdata['Card']['pover'] = 1;
                                unset($rqdata['Card']['status'], $rqdata['Card']['isperso']);
                                break;
                        case h_ov:
                                $rqdata['Card']['id'] = $rqdata['Event']['card_id'];
                                $rqdata['Card']['ishotstamp'] = 2;
                                unset($rqdata['Card']['status'], $rqdata['Card']['isperso']);
                                break;

                        case unlock_o:
                                $rqdata['Order']['status'] = W4UZUP;
                                $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                // zapamiętaj bierzący status zamówienia
                                $oldstat = $this->Order->order_status($rqdata['Event']['order_id']);
                                if ($oldstat >= 0)
                                        $rqdata['Order']['remstatus'] = $oldstat;
                                else
                                        $rqdata['Order']['remstatus'] = ABSURD;
                                $rqdata['Event'] = array($rqdata['Event']);
                                break;
                        case unlock_again:
                                $rqdata['Order']['id'] = $rqdata['Event']['order_id'];
                                $rqdata['Order']['status'] = W4UZUP;
                                $rqdata['Event'] = array($rqdata['Event']);
                                unset($rqdata['Card']);
                                break;
                        case klepnij:
                                //przywróć stary status zamówienia (a kart?)
                                $ord = $this->find('first', array(
                                        'conditions' => array('Order.id' => $rqdata['Event']['order_id']),
                                        'fields' => array('Order.id', 'Order.status', 'Order.remstatus')
                                ));
                                $rqdata['Order'] = $ord['Order'];
                                $rqdata['Order']['status'] = $rqdata['Order']['remstatus'];
                                $rqdata['Order']['remstatus'] = 0;
                                unset($rqdata['Card']);
                                break;

                        case eJPUBLI:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sDTP_REQ;
                                $rqdata['Job']['data_publikacji'] = date('Y-m-d H:i:s');
                                status_kart($rqdata['Card'], JOBED);
                                break;
                        case eJ_FILE1:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sHAS_F1;
                                $rqdata['Upload'] = $this->Job->Upload->manage_jobed_files($rqdata);
                                break;
                        case eJF_BACK:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sDTP2FIX;
                                unset($rqdata['Card']);
                                break;
                        case eJ_FILE2:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sHAS_F2;
                                $rqdata['Upload'] = $this->Job->Upload->manage_jobed_files($rqdata);
                                break;
                        case eJF_OK:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sW4B;
                                unset($rqdata['Card']);
                                break;
                        case eJ_B2KOR:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sKOR2FIX;
                                unset($rqdata['Card']);
                                break;
                        case eJ_B2DTP:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sDTP2FIX2;
                                unset($rqdata['Card']);
                                break;
                        case eJ_FILE3:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sW4B2;
                                $rqdata['Upload'] = $this->Job->Upload->manage_jobed_files($rqdata);
                                break;
                        case eJ_KOR2B:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sW4B2;
                                unset($rqdata['Card']);
                                break;
                        case eJ_KOR2DTP:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sDTP2FIX;
                                unset($rqdata['Card']);
                                break;
                        case eJ_ACC:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sJ_PROD;
                                status_kart($rqdata['Card'], W_PROD);
                                break;
                        case eJ_COF2KOR:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sPAUSE4K;
                                unset($rqdata['Card']);
                                break;
                        case eJ_COF2DTP:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sPAUSE4D;
                                unset($rqdata['Card']);
                                break;
                        case eJ_KBACK:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sBACK2B;
                                unset($rqdata['Card']);
                                break;
                        case eJ_DBACK:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sBACK2B;
                                $rqdata['Upload'] = $this->Job->Upload->manage_jobed_files($rqdata);
                                //unset($rqdata['Card']);			
                                break;
                        case eJB_UNPAUSE:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sJ_PROD;
                                unset($rqdata['Card']);
                                break;






                                //case eKOR_POP:
                        case eB_REJ2DTP:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sDTP_REQ;
                                unset($rqdata['Card']);
                                break;/*
                    case eDTP_REJ:
                            $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                            $rqdata['Job']['status'] = sDAFC;
                            unset($rqdata['Card']);
                            break;
                    */
                        case ePUSH2B:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sW4B;
                                unset($rqdata['Card']);
                                break;
                        case eB_REJ2KOR:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sASKOR;
                                unset($rqdata['Card']);
                                break;
                        case eB_REJ:
                                $rqdata['Job']['id'] = $rqdata['Event']['job_id'];
                                $rqdata['Job']['status'] = sB_REJ;
                                unset($rqdata['Card']);
                                break;
                } // end of switch

                /* Nie koniecznie potrzebne
                unset($rqdata['Event']['ile_events']);*/

                if (!in_array($event, array(unlock_again))) {
                        // chcemy się pozbyć tego poniżej i robić wszystko powyżej, więc tu wrunek, co bez nowych			//
                        if (in_array($event, array(put_kom, eJKOM, eJ_FILE1, eJ_FILE2, eJ_FILE3, eJ_DBACK, send_o, unlock_o, odemknij))) {
                                unset($rqdata['Card']);
                        } else {
                                $rqdata['Event'] = array($rqdata['Event']);
                        }
                }

                if ($event != eJ_FILE1 && $event != eJ_FILE2 && $event != eJ_FILE3 && $event != eJ_DBACK) {
                        unset($rqdata['Upload']);
                }

                if ($sav) {
                        $addPerso = $this->notifyPerso($event, $karty); // czy dodać powiadomienie dla perso
                        return $this->saveStuff($event, $rqdata, $addPerso);
                }
                return $rqdata;
        }

        private function saveStuff($event, $rqdata = array(), $addPerso = false)
        {

                $this->code = 1;

                $this->prepEmailData($rqdata['Event'], $addPerso);

                if (array_key_exists(0, $rqdata['Event'])) { // znaczy wersja dla hasMany
                        $rqdata['Event'][0]['odbiorcy'] = $this->e_data['odbiorcy'];
                        $rqdata['Event'][0]['temat'] = $this->e_data['temat'];
                        $rqdata['Event'][0]['url'] = Router::url($this->e_data['linktab'], true);
                } else {
                        $rqdata['Event']['odbiorcy'] = $this->e_data['odbiorcy'];
                        $rqdata['Event']['temat'] = $this->e_data['temat'];
                        $rqdata['Event']['url'] = Router::url($this->e_data['linktab'], true);
                }
                if (!in_array($event, array(odemknij, send_o, eJ_FILE1, eJ_FILE2, eJ_FILE3, eJ_DBACK))) {
                        if (array_key_exists('Order', $rqdata)) {
                                $this->code = 55;
                                if ($this->Order->saveAssociated($rqdata)) {
                                        if ($event == publi) {
                                                // w wypadku publikacji potrzebujemy nadać numer zamówieniu
                                                if ($this->Order->set_order_number())
                                                        return true;
                                                else {
                                                        $this->code = 2;
                                                        return false;
                                                }
                                        }
                                        return true;
                                } else {
                                        $this->code = 56;
                                }
                        } elseif (array_key_exists('Job', $rqdata)) {
                                if ($this->Job->saveAssociated($rqdata)) { //
                                        if ($event == eJPUBLI) { // w wypadku publikacji potrzebujemy nadać numer zleceniu
                                                if ($this->Job->set_job_number())
                                                        return true;
                                                else {
                                                        $this->code = 12;
                                                        return false;
                                                }
                                        }
                                        return true;
                                }
                        } elseif (array_key_exists('Card', $rqdata)) {
                                $this->code = 89;
                                if ($this->Card->saveAssociated($rqdata)) {
                                        return true;
                                }
                        } else {
                                if ($this->save($rqdata)) return true;
                        }
                } else {
                        switch ($event) {
                                case send_o:
                                        if ($this->save($rqdata)) {
                                                $wynik = $this->zamknijLubOtworz($rqdata['Event']['order_id']);
                                                if ($wynik['ok']) {
                                                        return true;
                                                } else {
                                                        $this->code = 215;
                                                }
                                        } else {
                                                $this->code = 123;
                                        }
                                        break;
                                case odemknij:
                                        if ($this->save($rqdata)) {
                                                // czyli otwórz - drugi argument == true
                                                $wynik = $this->zamknijLubOtworz($rqdata['Event']['order_id'], true);
                                                if ($wynik['ok']) {
                                                        return true;
                                                } else {
                                                        $this->code = 216;
                                                }
                                        } else {
                                                $this->code = 124;
                                        }
                                        break;
                                case eB_REJ2KOR:
                                case eB_REJ2DTP:
                                case eJ_ACC:
                                        if ($this->Job->saveAssociated($rqdata)) {
                                                return true;
                                        } else {
                                                return false;
                                        }
                                case eJ_FILE1:
                                case eJ_FILE2:
                                case eJ_FILE3:
                                case eJ_DBACK:
                                        if (!empty($rqdata['Upload']) || $event == eJ_FILE3 || $event == eJ_DBACK) {
                                                $evrecord = array('Event' => $rqdata['Event']);
                                                unset($rqdata['Event']);
                                                $this->create();
                                                if ($this->save($evrecord)) {
                                                        $evid = $this->id;
                                                        foreach ($rqdata['Upload'] as &$plikdata) {
                                                                $plikdata['event_id'] = $evid;
                                                        }
                                                        if ($this->Job->saveAssociated($rqdata)) {
                                                                return true;
                                                        } else {
                                                                return false;
                                                        }
                                                } else {
                                                        return false;
                                                }
                                        } else {
                                                return false;
                                        }
                                        break;
                        }
                }
                return false;
        }

        public $saveEventError;

        public function saveEventAndRelated($ds = array())
        {

                $this->saveEventError = 0;
                if ($this->Order->saveAssociated($ds)) return true;
                return false;
        }

        /**
         * Validation rules
         *
         * @var array
         */
        public $validate = array(
                'user_id' => array(
                        'numeric' => array(
                                'rule' => array('numeric'),
                                //'message' => 'Your custom message here',
                                //'allowEmpty' => false,
                                //'required' => false,
                                //'last' => false, // Stop validation after this rule
                                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                        ),
                ),
                'order_id' => array(
                        'numeric' => array(
                                'rule' => array('numeric'),
                                //'message' => 'Your custom message here',
                                //'allowEmpty' => false,
                                //'required' => false,
                                //'last' => false, // Stop validation after this rule
                                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                        ),
                ),
                'job_id' => array(
                        'numeric' => array(
                                'rule' => array('numeric'),
                                //'message' => 'Your custom message here',
                                //'allowEmpty' => false,
                                //'required' => false,
                                //'last' => false, // Stop validation after this rule
                                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                        ),
                ),
                'card_id' => array(
                        'numeric' => array(
                                'rule' => array('numeric'),
                                //'message' => 'Your custom message here',
                                //'allowEmpty' => false,
                                //'required' => false,
                                //'last' => false, // Stop validation after this rule
                                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                        ),
                ),
                'co' => array(
                        'numeric' => array(
                                'rule' => array('numeric'),
                                //'message' => 'Your custom message here',
                                //'allowEmpty' => false,
                                //'required' => false,
                                //'last' => false, // Stop validation after this rule
                                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                        ),
                ),/*
		'post' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
        );

        //The Associations below have been created with all possible keys, those that are not needed can be removed

        /**
         * belongsTo associations
         *
         * @var array
         */
        public $belongsTo = array(
                'User' => array(
                        'className' => 'User',
                        'foreignKey' => 'user_id',
                        'conditions' => '',
                        'fields' => '',
                        'order' => ''
                ),
                'Order' => array(
                        'className' => 'Order',
                        'foreignKey' => 'order_id',
                        'conditions' => '',
                        'fields' => '',
                        'order' => ''
                ),
                'Job' => array(
                        'className' => 'Job',
                        'foreignKey' => 'job_id',
                        'conditions' => '',
                        'fields' => '',
                        'order' => ''
                ),
                'Card' => array(
                        'className' => 'Card',
                        'foreignKey' => 'card_id',
                        'conditions' => '',
                        'fields' => '',
                        'order' => ''
                )
        );
}
