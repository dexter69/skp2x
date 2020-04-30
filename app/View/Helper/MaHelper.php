<?php

App::uses('AppHelper', 'View/Helper');

class MaHelper extends AppHelper {
	
	public $helpers = array('Number','Form','Html');

	public $perso3opcje = array(
		'podlam' => array(
			0 => null,
			1 => 'pod laminat'
		),
		'plaska' => array(
			0 => null,
			1 => 'płaska'
		),
		'emboss' => array(
			0 => null,
			1 => 'embossing'
		),
		'podlam-span' => array(
			0 => null,
			1 => '<span>pod laminat</span>'
		),
		'plaska-span' => array(
			0 => null,
			1 => '<span>płaska</span>'
		),
		'emboss-span' => array(
			0 => null,
			1 => '<span>embossing</span>'
		)
	);
	
	// wspomaganie do event buttons
	public $button_val = array(
		ZERO => 'ZERO',
		
		
		publi => 'PUBLIKUJ',
		kor_no => //'kor_no',
				'ODRZUĆ',	
		kor_ok => //'kor_ok',
				'AKCEPTUJ',
                p_ov => 'perso gotowe',
		d_no => 'odrzuć pliki',//'d_no',
		p_no => 'odrzuć perso',
		d_ok => 'akceptuj pliki',//'d_ok',
		p_ok => 'akceptuj perso',
		fix_o => 'AKTUALIZUJ',
				//	'fix_o',
		send_o => 'ZAMKNIJ',
		unlock_o => 'ODBLOKUJ',
		update_o => 'UZUPEŁNIONE',
		unlock_again => 'ZWRÓĆ',
		klepnij => 'PRZYJMIJ',
		push4checking => 'DO DTP/P',
        odemknij => 'OTWÓRZ',		
        
		h_ov => 'HOT OK',
		

		put_kom => 'napisz',//'put_kom',
		
		
		
		eJPUBLI => 'PUBLIKUJ',
		eJKOM => 'KOMENTARZ',
		eJ_FILE1 => 'WYŚLIJ',//'eJ_FILE1',
		eJ_FILE2 => 'WYŚLIJ',//'eJ_FILE2',
		eJ_FILE3 => 'WYŚLIJ',//'eJ_FILE3',
		eJF_BACK => 'ZWRÓĆ',//'eJF_BACK',
		eJ_B2KOR => 'ZWROT DO TECHNOLOGA ',
		eJ_B2DTP => 'ZWROT DO DTP',
		eJ_KOR2B => 'DO KIEROWNIKA',//'eJ_KOR2B',
		eJ_KOR2DTP => 'DO DTP',//'eJ_KOR2DTP',
		eJ_ACC => 'AKCEPTUJ',
		eJ_COF2KOR => 'ZWROT DO TECHNOLOGA ',
		eJ_COF2DTP => 'ZWROT DO DTP',
		eJ_KBACK => 'DO KIEROWNIKA',
		eJ_DBACK => 'DO KIEROWNIKA',
		eJB_UNPAUSE => 'AKCEPTUJ',//'eJB_UNPAUSE',
		
		
		/*
		eDTP_REJ => 'eDTP_REJ',
		eKOR_POP => 'POPRAWIONE',
		*/
		
		eJF_OK => 'AKCEPTUJ',//'eJF_OK',
		eJF_OK => 'AKCEPTUJ',//'eJF_OK',
		eB_REJ => 'ODRZUĆ',
		eB_REJ2KOR => 'ZWROTDOKOR',
		eB_REJ2DTP => 'ZWROTDODTP',
		eK_POP4B => 'eKOR_POP4B',
		eK_PUSHDTP => 'eK_PUSHDTP'
		
	);
	
	public $button_req = array(
		ZERO => false,
			
		publi => false,
		kor_no => true,
		kor_ok => false,
                p_ov => false,
		d_no => true,
		p_no => true,
		d_ok => false,
		p_ok => false,
		fix_o => false,
		send_o => false,
		unlock_o => false,
		unlock_again => true,
		klepnij => false,
		/* deprec
		kor_no1 => true,
		kor_ok1 => false,
		kor_no2 => true,
		kor_ok2 => false,
		fix_o1 => false,
		fix_o2 => false,
		*/
		
		h_ov => false,
		
		put_kom => true,
		update_o => true
	);	
	
	
	
		//Status zlecenia (jobs)
	
	public $job_stat = array(
		sPRIVJ => 'PRYWATNE',
		sDTP_REQ => 'NOWE',
		//sDTP_REQ => 'DAJ PLIKI',
		sHAS_F1 => 'SĄ PLIKI',
		sDTP2FIX => 'DO POPRAWY',
		sHAS_F2 => 'SĄ PLIKI',
		sW4B => 'KIEROWNIK',
		sDTP2FIX2 => 'DO POPRAWY',
		sKOR2FIX => 'DO POPRAWY',
		sW4B2 => 'KIEROWNIK',
		
		
		sJ_PROD => 'PRODUKCJA',
		sPAUSE4K => 'WSZTRZYM. KOR',
		sPAUSE4D => 'WSZTRZYM. DTP',
		sBACK2B => 'POPRAWIONE',
		
		sDAFC => 'sDAFC',
		sB_REJ => 'sB_REJ',
		sASKOR => 'sASKOR',
		
		KONEC => 'ZAKOŃCZONE'
		
	);
	
	//wyświetlanie tekstów o zdarzeniach
	public $evtext = array(
		ZERO => array(
			'',
			'','class' => 'zadna'),
		publi => array(
			'złożył',
			'złożyła','class' => 'pom'),
		kor_ok => array(
			'zatwierdził',
			'zatwierdziła','class' => 'ziel'),
		kor_no => array(
			'odrzucił',
			'odrzuciła','class' => 'czer'),
		
		
		d_ok => array(
			'zatwierdził kartę:',
			'zatwierdziła kartę:','class' => 'ziel'),
		d_no => array(
			'odrzucił kartę:',
			'odrzuciła kartę:','class' => 'czer'),
		p_ok => array(
			'zatwierdził perso: ',
			'zatwierdziła perso: ','class' => 'ziel'),
		p_no => array(
			'odrzucił perso: ',
			'odrzuciła perso: ','class' => 'czer'),
		put_kom => array(
			'skomentował',
			'skomentowała','class' => 'pom'),
		fix_o => array(
			'poprawił',
			'poprawiła','class' => 'pom'),	
		send_o => array(
			'zakończył',
			'zakończyła','class' => 'ziel'),			

			
		eJPUBLI => array(
			'złożył zlecenie',
			'złożyła zlecenie','class' => 'pom'),
		eJKOM => array(
			'napisał:',
			'napisała:','class' => 'pom'),/*
		eDTP_REJ => array(
			'odrzucił zlecenie',
			'odrzuciła zlecenie','class' => 'czer'),
		eKOR_POP => array(
			'poprawił zlecenie',
			'poprawiła zlecenie','class' => 'ziel')	,*/
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
			'poprawił',
			'poprawiła','class' => 'pom'),
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
			'zatwierdziła','class' => 'ziel')
	
	);
        
        public function walnijJqueryUI( $jquery = false ) {
        // coby wypluć ui na stronie
        // Produkuje styl + jqueryUI, domyślnie nie daje jquery ($jquery = false)
            return 
                $this->Html->css(array('custom-theme3/jquery-ui.min'), array('inline' => false)) .
                $this->Html->script(array('jquery-ui'), array('inline' => false)); 
        }
        
        public function jqueryUItoolTip( $selektor = null ) {
        // trzeba się upewnić, że jquery UI jest wcześniej załadowane
            $code = "$(function() {" .
                        "$( '" . $selektor . "' ).tooltip();" .
                    "});";
            return $this->Html->scriptBlock($code, array('inline' => false));
            
        }
        
        /*  #################################################################
         *   CECHY kart, zamówień i zleceń
         */
        
        public $tablica_cech = array();
        
        // wzór pustej tablicy cech
        private $tablica_cech_wzor = array(
            //na razie tylko personalizacja + hotstamping
            'set' => false, // ustawiona -> true, zrestetowana/pusta -> false
            'isperso' => false, // ogólnie czy jest, może się przyda?
            'pl' => false, // personalizacja pod laminatem
            'pt' => false, // personalizacja płaska albo Termodruk
            'pe' => false, // Embossing
            'pp' => false, /* personalizacja ogólnie, że jest
                            Zasada:
                                'pp' == true, to wszystkie inne false (stara karta)
                                 i na odwrót, któraś z 3-ech true, to 'pp' false
                            */
			'hot' => false // Hotstamping
        );
        
        private $ztitles = array(
            'p-plaska' => 'personalizacja PŁASKA',
            'p-laminat' => 'personalizacja pod LAMINATEM',
            'p-emboss' => 'EMBOSSING',
            'p-old' => 'personalizacja',
			'hot' => 'Hotstamping'
        );

        private function getAndSetCechyKarty( $karta = array() ) {
            // odczytajmy z karty w formacie bazy, co ona ma i zwróćmy jako cechy w
            // formacie tablicy $tablica_cech oraz ustawmy te wartości w tej tablicy
            $this->resetTablicaCech(); // reset gwarantowany
            if( !empty($karta) ) {
                $this->tablica_cech['set'] = true; // tak, bo sprawdziliśmy i ustawiliśmy
                // na razie tylko perso + hotstamping
                if( $karta['isperso'] ) {
                   $this->tablica_cech['isperso'] = true;                   
                   $this->tablica_cech['pl'] =  $karta['pl'] == '1';
                   $this->tablica_cech['pt'] =  $karta['pt'] == '1';
                   $this->tablica_cech['pe'] =  $karta['pe'] == '1';
                   if( !$this->tablica_cech['pl'] && !$this->tablica_cech['pt'] &&
                       !$this->tablica_cech['pe'] ) { 
                       $this->tablica_cech['pp'] = true; // znaczy perso "po staremu"
                   }
                }    
				if( $karta['ishotstamp'] ) {
					$this->tablica_cech['hot'] = true;
				}
            }
            return $this->tablica_cech;
        }       
        
        
        private function resetTablicaCech() {
            $this->tablica_cech = $this->tablica_cech_wzor;
        }

        public function cechyKarty( $karta = array(), $wrap_klasa = null ) {
            
			$html = null;
            $this->getAndSetCechyKarty( $karta );
            if( $this->tablica_cech['isperso'] ) {                
                if( $this->tablica_cech['pp'] ) { // karta po staremu
                    $html .= $this->markCechy('?', 'p-old', $this->ztitles['p-old']);
                } else { // karta po nowemu
                    if( $this->tablica_cech['pl'] ) { $html .= $this->markCechy('L', 'p-lam', $this->ztitles['p-laminat']); }
                    if( $this->tablica_cech['pt'] ) { $html .= $this->markCechy('P', 'p-pla', $this->ztitles['p-plaska']); }
                    if( $this->tablica_cech['pe'] ) { $html .= $this->markCechy('E', 'p-emb', $this->ztitles['p-emboss']); }
                }
                $klasa = 'cechy-wrap';                
            }
			if( $this->tablica_cech['hot'] ) { // jest hotstamping
				$html .= $this->markCechy('H', 'hot', $this->ztitles['hot']);
				$klasa = 'cechy-wrap';
			}
			if( $html ) {
				if( $wrap_klasa != null ) {
                    $klasa .= ' ' . $wrap_klasa;
                }
            	$html = '<div class="' . $klasa . '"><div class="process perso">' . $html . '</div></div>';
			}            
            return $html;
        }
        
//        $znaczki_titles = array(
//            'p-plaska' => 'personalizacja PŁASKA',
//            'p-laminat' => 'personalizacja pod LAMINATEM',
//            'p-emboss' => 'EMBOSSING',
//            'p-old' => 'personalizacja'
//			  'hot' => 'hotstamping'
        
        private function markCechy( $char = null, $klasa = null, $title = null ) {
            
            if( $klasa != null ) {
                $klasa = ' class="' . $klasa . '"';
            }
            if( $title != null ) {
                $title = ' title="' . $title . '"';
            }
            return '<div' . $klasa . $title . '><div>' . $char . '</div></div>';
        }
        /*   CECHY kart, zamówień i zleceń
         *  ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
         */ 

	public function mjson( $stri = null ) {
	
            $str = json_encode($stri);
            
            $str = preg_replace_callback(
             '/\\\\u([0-9a-f]{4})/i',
             function ($matches) {
            $sym = mb_convert_encoding(
                    pack('H*', $matches[1]), 
                    'UTF-8', 
                    'UTF-16'
                    );
                return $sym;
            },
            $str
            );

            return $str;
	}
	
	public function responsive_divs( $markup = null, $htmlid = null ) {
		
		echo $this->Html->div('the_awesome', null, array('id' => $htmlid));
		echo $markup;
		echo $this->Html->tag('/div');	
	}
	
	public function responsive_divs2( $markup = null, $htmlid = null ) {
		
		return 	$this->Html->div('the_awesome', null, array('id' => $htmlid)) .
				$markup . $this->Html->tag('/div');	
	}
	
	public $mies_full = array(
		'01' => 'styczeń',
		'02' => 'luty',
		//'02' => 'październik',
		'03' => 'marzec',
		'04' => 'kwiecień',
		'05' => 'maj',
		'06' => 'czerwiec',
		'07' => 'lipiec',
		'08' => 'sierpień',
		'09' => 'wrzesień',
		'10' => 'październik',
		'11' => 'listopad',
		'12' => 'grudzień'
	);
        
        public $mies_short = array(
		'01' => 'sty',
		'02' => 'lut',
		//'02' => 'październik',
		'03' => 'mar',
		'04' => 'kwi',
		'05' => 'maj',
		'06' => 'cze',
		'07' => 'lip',
		'08' => 'sie',
		'09' => 'wrz',
		'10' => 'paź',
		'11' => 'lis',
		'12' => 'gru'
	);
	
	public function md($dstring, $short = false) { //moja data

		if( $dstring ) {
                        if( $short ) 
                            { $mies =  $this->mies_short[substr($dstring, 5, 2)]; }
                        else
                            { $mies =  $this->mies_full[substr($dstring, 5, 2)]; }
			return	substr($dstring, 8, 2).' '. //dzien
				//'październik'.' '.        //miesiac
				$mies .' '.                 //miesiac
				substr($dstring, 0, 4);     //rok
                } else  { return $dstring; }
	}
        
        public function mdvs( $dstring ) { //moja data bardzo krótka
            
            if( $dstring ) {
                //$mies =  $this->mies_short[substr($dstring, 5, 2)];
                return 
                    substr($dstring, 8, 2).' '.                 //dzien
                    $this->mies_short[substr($dstring, 5, 2)]; // miesiąc     
            } else  { 
                return $dstring;                 
            }
        }
		
	public function mdt($dstring = null, $seconds = false) { //moja data i czas

		if( $dstring ) {
                        $zwr =  substr($dstring, 8, 2).' '. 					//dzien
                                $this->mies_full[substr($dstring, 5, 2)].' '.	//miesiac
				substr($dstring, 0, 4)	.', '.					//rok
				//substr($dstring, -8);							//godzina
				substr($dstring, 11, 5);
                        if( $seconds ) { $zwr .= substr($dstring, -3); }
			return	$zwr;						//godzina bez sekund
                } else
                    { return 	$dstring; }
	}
	
	
	
    public function tys($nr) {
        // Logic to create specially formatted link goes here...
		return $this->Number->format($nr, array(
    			'places' => 0,
    			'before' => null,
    			//'escape' => false,
    			//'decimals' => '.',
    			'thousands' => ' '
			));
		
    }
	
	
	public function colon($nr, $places = 4) {
        // Logic to create specially formatted link goes here...
		return $this->Number->format($nr, array(
    			'places' => $places,
    			'before' => null,
    			//'escape' => false,
    			'decimals' => ',',
    			'thousands' => ' '
			));
		
    }

	//produkcja nr z id
	public function id2nrh($id) {
		return $id.'/'.NR_SUFIX.'h';
	}
	
	public function formularzSzukajKarty() {
		
		$htmlcode = 
		$this->Form->create('Card', array(
			'id' => 'sk-form',
                        'action' => 'search' )) .
			$this->Form->input('sirczname', array(
				'label' => false,
				'required' => true,
				'placeholder' => 'Wpisz szukaną frazę'
			)) .			
		$this->Form->end('szukaj') .	
		'<p class="klose-mark"></p>';
		
		return $htmlcode;
	}
	
	// convert base nr to nrh - numer handlowego
	public function bnr2nrh($bnr = null, $inicjaly = null, $ishtml = true) {
		
		if($bnr && $bnr > BASE_NR) {
			if( $ishtml ) {
				$startspan = '<span class="ordernr">';
				$stopspan = '</span>';
			} else 
				$startspan = $stopspan = null;
			if( $inicjaly )
				return (int)substr((int)$bnr,2).$startspan.'/'.substr((int)$bnr,0,2).' '.$inicjaly.$stopspan;
			else
				return (int)substr((int)$bnr,2).$startspan.'/'.substr((int)$bnr,0,2).' H'.$stopspan;
		} else
			return $bnr;
		
	}	
	
	public function status_karty($stat, $short = false) {
		if( $stat != NULL) {
                    if( $short ) {
                       return $this->card_stat_short[$stat]; 
                    }
                    return $this->card_stat[$stat];
                }
		return $stat;
	}

	public function kontrolka($card, $evcontrol) {
		
		if($evcontrol['ile']) { //wyświetlamy formularz, jeżeli są w ogle jakieś submity
			
			echo $this->Html->div('events form');
			echo $this->Form->create('Event', array(
    			'url' => array('controller' => 'events', 'action' => 'add')
			));
		
			echo $this->Html->tag('fieldset');
			echo $this->Form->hidden('card_id', array('default' => $card['Card']['id']));
			echo $this->Form->hidden('order_id', array('default' => $card['Card']['order_id']));
			echo $this->Form->hidden('job_id', array('default' => 0));
			echo $this->Form->hidden('co', array('default' => ZERO));
			echo $this->Form->hidden('Card.status',array('default' => $card['Card']['status']));
			echo $this->Form->hidden('Card.isperso',array('default' => $card['Card']['isperso']));
			echo $this->Form->input('post', array('label' => 'Komentarz'));
		
			//echo $this->Form->input('Card.id',array('default' => $card['Card']['id']));
			
			$buttons = $evcontrol['buttons'];
			$bcontr = $evcontrol['bcontr'];
		
			foreach ( $buttons as $val ) {
				if( $bcontr[$val] ) $thecl = 'submit'; else $thecl = 'submit nieaktywny';
				echo $this->Form->submit($this->button_val[$val], array(
					'class' => 'eventsub',
					'co'=>$val,
					'div' => array('class' => $thecl),
					'req'=>$this->button_req[$val]  
				));
			}
		
			echo $this->Html->tag('/fieldset');
			echo $this->Form->end();
			echo $this->Html->tag('/div');
		}
	}	


	public function kontrolka_ord($order, $evcontrol, $przypominajka = false ) {
		
        if($evcontrol['ile']) { //wyświetlamy formularz, jeżeli są w ogle jakieś submity

            //echo '<pre>'; print_r($evcontrol); echo  '</pre>';

            echo $this->Html->div('event-order');
            echo $this->Form->create('Event', array(
            'url' => array('controller' => 'events', 'action' => 'add')
            ));
            echo $this->Html->tag('fieldset');
            echo $this->Form->hidden('card_id', array('default' => 0));
            echo $this->Form->hidden('order_id', array('default' => $order['Order']['id']));
            echo $this->Form->hidden('job_id', array('default' => 0));
            echo $this->Form->hidden('co', array('default' => ZERO));
            /*	Myk: dzięki temu polu wiemy, ile jest zdarzeń pod zamówieniem.
                Dzięki temu, przy publikacji zamówienie wiemy, czy jest to pierwsza
                publikacja, czy kolejna - czyli serwisowa  */
            echo $this->Form->hidden('ile_events', ['default' => count($order['Event'])] );

            // idki podpiętych kart
            $i=0;
            foreach ($order['Card'] as $karta) {
                echo $this->Form->input('Card.'.$i.'.id',array('default' => $karta['id']));
                echo $this->Form->hidden('Card.'.$i.'.status',array('default' => $karta['status']));
                echo $this->Form->hidden('Card.'.$i.'.isperso',array('default' => $karta['isperso']));
                /* Jeżeli publikujemy, to dajemy info przydatne w przypadku kart serwisowych */
                if( $evcontrol['bcontr'][publi] ) {
                    echo $this->Form->hidden('Card.'.$i.'.left',array('default' => $karta['left']));
                    echo $this->Form->hidden('Card.'.$i.'.pover',array('default' => $karta['pover']));
                }
                if( $evcontrol['bcontr'][push4checking] ) {
                        echo $this->Form->hidden('Card.'.$i.'.D', array('default' => 0));
                        echo $this->Form->hidden('Card.'.$i.'.P', array('default' => 0));
                        echo $this->Form->hidden('Card.'.$i.'.remstatus',array('default' => $karta['remstatus']));
                }
                $i++;
                //echo $this->Form->input('Card.'.$i++.'.status',array('default' => $karta['status']));
            }
            echo $this->Form->input('post', array('label' => 'Komentarz'));

            //$buttons = $evcontrol['buttons'];
            //$bcontr = $evcontrol['bcontr'];
            echo $this->Html->div('subwrap');
            foreach ( $evcontrol['buttons'] as $val ) {
                if( $evcontrol['bcontr'][$val] ) $thecl = 'submit'; else $thecl = 'submit nieaktywny';
                if( array_key_exists($val, $this->button_val) )
                        $nazwa_klawisza = $this->button_val[$val];
                else 
                        $nazwa_klawisza = $val;
                if( array_key_exists($val, $this->button_req) )
                        $wymagany = $this->button_req[$val];
                else
                        $wymagany = 0;
                echo $this->Form->submit($nazwa_klawisza, array(
                        'class' => 'eventsub',
                        'co'=>$val,
                        'div' => array('class' => $thecl),
                        'req'=>$wymagany  
                ));
            }
            echo $this->Html->tag('/div');
            if( $przypominajka ) {
                echo $przypominajka;
            }            
            echo $this->Html->tag('/fieldset');
            echo $this->Form->end();
            echo $this->Html->tag('/div');  
        }
	}	
															 
	public function kontrolka_job($job, $submity) {
		
		function plikoza($przyciski = array()) {
			
                    if( !empty($przyciski) ) {
                        if  ( 	array_key_exists(eJ_FILE1, $przyciski) ||
                                array_key_exists(eJ_FILE2, $przyciski) ||
                                array_key_exists(eJ_FILE3, $przyciski) ||
                                array_key_exists(eJ_DBACK, $przyciski)) {
                                return true; }
                    }
                    return false;
		}
		
		if(count($submity))	{
			
			$formoptions = array(
    				'url' => array('controller' => 'events', 'action' => 'add')
			);
			$inputfile = false;
			if( plikoza($submity) ) { 
				$formoptions['type'] = 'file';				
				$inputfile = true;
			}
			echo $this->Html->div('event-order');
			echo $this->Form->create('Event', $formoptions );
			echo $this->Html->tag('fieldset');
			echo $this->Form->hidden('card_id', array('default' => 0));
			echo $this->Form->hidden('order_id', array('default' => 0));
			echo $this->Form->hidden('job_id', array('default' => $job['Job']['id']));
			echo $this->Form->hidden('co', array('default' => ZERO));
			
			// idki podpiętych kart
			$i=0;
			foreach ($job['Card'] as $karta) {
				echo $this->Form->input('Card.'.$i++.'.id',array('default' => $karta['id']));
			}
			
			echo $this->Form->input('post', array('label' => 'Komentarz'));
			
			echo $this->Html->div('subwrap');
			foreach ( $submity as $key => $val ) {
				if( $key ) $thecl = 'submit'; else $thecl = 'submit nieaktywny';
				if( $key == eJ_FILE1 || $key == eJ_FILE2 ) $plik=1; else $plik=0;
				echo $this->Form->submit($this->button_val[$key], array(
					'class' => 'eventsub',
					'co'=>$key,
					'div' => array('class' => $thecl),
					'req'=>$val,
					'plik'=>$plik
				));
			}
			echo $this->Html->tag('/div');
			
			if( $inputfile ) {
				echo $this->Form->input('Upload.files.', array( 								
								'type' => 'file',
								'required' => false,
								'multiple'								
							));	
			}
			
			
			echo $this->Html->tag('/fieldset');
			echo $this->Form->end();
			echo $this->Html->tag('/div');
		}													 
	
	}
	
	public function ordersInJob($data) {
		
            $k=0; $table = array();
            foreach( $data as $row ) {

                $ile = $row['Card']['ilosc'] * $row['Card']['mnoznik'];
                $cid = $row['Card']['id'];
                $oid = $row['Card']['order_id'];
                if( $row['Card']['job_id'] ) $checked = true; else $checked = false;

                $ilosc = array( $this->tys($ile), array('class' => 'ile') );
                $input =  $this->Form->input('Card.'.$k.'.checked', array(
                        'type' => 'checkbox',
                        'checked'=> $checked,
                        'label' => false,
                        'div' => false,
                        'order_id' => $oid,
                        'card_id' => $cid,
                        'ilosc' => $ile
                ));

                $cidin = $this->Form->input('Card.'.$k.'.id',array('default' => $cid));
                $jobid = $this->Form->hidden('Card.'.$k.'.job_id',array('default' => $row['Card']['job_id']));

                $cbox = array($cidin.$jobid.$input, array('class' => 'cbox'));
                
                //info o płatności
                $klasa_dolarka = $this->klasaDolara($row['Order']['forma_zaliczki'], $row['Order']['stan_zaliczki']);
                
                $dolar = array('<i class="fa fa-usd" aria-hidden="true" dolar="one"></i>', array('class' => $klasa_dolarka));

                $cardname = array($this->Html->link($row['Card']['name'], array('controller' => 'cards', 'action' => 'view', $row['Card']['id'])), array('class' => 'karta'));

                $klastr = 'normal';
                
                $utech = array( '<p id="wyz' . $cid . '" class="wyzwalacz"></p><div class="'.$klastr.'">'.$this->Form->input('Card.'.$k.'.tech_comment',
                        array(
                            'default' => $row['Card']['tech_comment'],
                            'label' => false,
                            //'div' => array( 'class' => $klastr)
                            'div' => false,
                            'data-kid' => $cid
                        )).'<p class="zamek"></p></div>',
                        array('class' => 'utech')
                );    
                //'<textarea name="data[Card][0][tech_comment]" id="Card0TechComment">'
                //$htmlstr = 
                $nr_zam = $this->Html->link($this->bnr2nrh($row['Order']['nr'], $row['Creator']['inic']), array('controller' => 'orders', 'action' => 'view', $row['Order']['id']), array('escape' => false)); 
                $termin = array( $this->md($row['Order']['stop_day']), array('class' => 'czas') );

                $klient = array($row['Customer']['name'], array('class' => 'klient'));
                $handlowiec = array( $row['Creator']['name'], array('class' => 'handel') );

                $input =  $this->Form->input('Card.'.$k++.'.ikna', array(
                        //'type' => 'checkbox',
                        //'checked'=>false,
                        'label' => false,
                        'div' => false,
                        'card_id' => $cid,
                        //'ilosc' => $ile
                        'min' => 0,
                        'max' => 99,
                        'default' => $row['Card']['ikna']
                ));

                $ikna = array($input, array('class' => 'ikna'));

                $table[] = array( $cbox, $dolar, $cardname, $utech, $nr_zam, $klient, $handlowiec, $ilosc, $ikna, $termin );



            }
            $table[] = array('<div></div>','','',
                                '','','',
                                array('', array('class' => 'suma')),
                                array('', array('class' => 'iknas')),
                                ''
            );


            echo $this->Html->tag('table', null, array( 'class' => 'j-add' ));

                    echo $this->Html->tableHeaders( array(
                            array('' => array('class' => 'cbox')),
                            array(''  => array('class' => 'dolar')),
                            array('Karta'  => array('class' => 'karta')),
                            array(''  => array('class' => 'utech')),
                            array('Nr (H)' => array('class' => 'nr')),
                            array('Klient'  => array('class' => 'klient')),
                            array('Opiekun' => array('class' => 'handel')),
                            array('Ilość' => array('class' => 'ile')),
                            array('IKNA' => array('class' => 'ikna')),
                            array('Termin' => array('class' => 'czas'))




                    ));
                    echo $this->Html->tableCells($table);

            echo $this->Html->tag('/table');

			
	}
        
        // ustalamy jaki kolor powinien mieć dolarek
        public function klasaDolara( $formaZaliczki = null, $stanZaliczki = null) {
            
            if( $formaZaliczki > 1 ) { // jest zaliczka
                    switch( $stanZaliczki ) {
                        case null: $klasa_dol = 'dolar red'; break; // brak jakiegokolwiek wpisu
                        case 'confirmed': $klasa_dol = 'dolar ora'; break; // potwierdzona wpłata
                        case 'money': $klasa_dol = 'dolar gre'; break; // są pieniądze na koncie
                    }
            } else {                    
                $klasa_dol = 'dolar gre'; }
            return $klasa_dol;
        }
	
	//Status kart (cards)
	public $card_stat = array(
		PRIV => 'PRYWATNA',//'PRIV',
		NOWKA => 'NOWA',//'NOWKA',
		W4D => 'DTP?',
				//'W4D',
		W4DP => 'DTP?/P?',
				//'W4DP',
		W4DPNO => 'DTP?/P-',
					//'W4DPNO',
		W4DPOK => // 'W4DPOK',
					'DTP?/P+',
		W4PDNO => // 'W4PDNO',
					'DTP-/P?',
		W4PDOK => // 'W4PDOK',
					'DTP+/P?',
		DOK => 	'DTP+' ,
				//'DOK',
		DNO => 'DTP-',
				//'DNO',
		DOKPNO => //'DOKPNO',
					'DTP+/P-',
		DOKPOK => 'DTP+/P+',
					//'DOKPOK',
		DNOPNO => 'DTP-/P-',
					//'DNOPNO',
		DNOPOK	=> 'DTP-/P+',
					//'DNOPOK',
		
		KONEC => 'ZAKOŃCZONA',
		W4P => 'DTP OK',
		W4P => 'PERSO?',//'W4P',
		DREJ => 'BŁĘDY W PLIKACH',
		PREJ => 'BŁEDY W PERSO',
		D_OK => 'PLIKI OK',
		P_OK => 'PERSO OK',
		R2BJ => 'SPRAWDZONA',//'R2BJ',
		JOBED => 'P.D.P.',//'JOBED',
		W_PROD => 'PRODUKCJA'//'W_PROD'
	);
        
        public $card_stat_short = array(
		PRIV => 'PRYW.',
		NOWKA => 'NOWA',
		W4D => 'DTP?',
		W4DP => 'DTP?/P?',
		W4DPNO => 'DTP?/P-',
		W4DPOK => 'DTP?/P+',
		W4PDNO => 'DTP-/P?',
		W4PDOK => 'DTP+/P?',
		DOK => 	'DTP+',
		DNO => 'DTP-',
		DOKPNO => 'DTP+/P-',
		DOKPOK => 'DTP+/P+',
		DNOPNO => 'DTP-/P-',
		DNOPOK	=> 'DTP-/P+',
		KONEC => 'ZAKOŃ.',
		W4P => 'DTP OK',
		W4P => 'PERSO?',
		DREJ => 'BŁĘDY',
		PREJ => 'BŁEDY',
		D_OK => 'DTP OK',
		P_OK => 'PER OK',
		R2BJ => 'SPRAWDZONA',
		JOBED => 'P.D.P.',
		W_PROD => 'PRODUK.'
	);
	
	
	// XXXXXX  JOBS XXXXXXX
	
	public function editlink($obj = null, $objid = 0) {
		
		$zwrot = null;
		if($objid && $obj !=null) {
			switch($obj) {
				case 'job':
					$zwrot = $this->Html->link('<div></div>', 
								array('controller' => 'jobs', 'action' => 'edit', $objid),
								array('class' => 'edlink',  'escape' =>false)
					);
				break;
				case 'order':
					$zwrot = $this->Html->link('<div></div>', 
								array('controller' => 'orders', 'action' => 'edit', $objid),
								array('class' => 'edlink',  'escape' =>false)
					);
				break;
				case 'card':
					$zwrot = $this->Html->link('<div></div>', 
								array('controller' => 'cards', 'action' => 'edit', $objid),
								array('class' => 'edlink karta',  'escape' =>false)
					);
				break;
				case 'customer':
					$zwrot = $this->Html->link('<div></div>', 
								array('controller' => 'customers', 'action' => 'edit', $objid),
								array('class' => 'edlink',  'escape' =>false)
					);
				break;
			}
		}
		return $zwrot;
	}
        
        public function pdflink($obj = null, $objid = 0) {
            
            $zwrot = null;
		if($objid && $obj !=null) {
                    switch($obj) {
                        case 'order':
                            $zwrot = $this->Html->link(
                                '<div></div>', 
				array('controller' => 'orders', 'action' => 'view', $objid, 'ext' => 'pdf'),
				array('class' => 'pdflink',  'escape' =>false)
                            );
                        break;
                        case 'job':
                            $zwrot = $this->Html->link(
                                '<div></div>', 
				array('controller' => 'jobs', 'action' => 'view', $objid, 'ext' => 'pdf'),
				array('class' => 'pdflink',  'escape' =>false)
                            );
                        break;
                    }
                }
            return $zwrot;
        }

	
	public $arkusz = array(
		SMALL_SHEET => 'PRZEWRO',
		BIG_SHEET => 'OSOBNO',
		OTHER_SHEET => 'INNY'
	);
	
	public $link_tab = array(
		
		aUSER_ADD => array(
			'tekst' => '+U',
			'controller' => 'users',
			'action' => 'add'
		),
		aUSER_LIST => array(
			'tekst' => 'U',
			'controller' => 'users',
			'action' => 'index'
		),
		
		aCUS_ADD => array(
			'tekst' => '',
			'controller' => 'customers',
			'action' => 'add',
			'class' => 'cuadd'
		),
		aCUS_LIST => array(
			'tekst' => '',
			'controller' => 'customers',
			'action' => 'index',
			'class' => 'culist'
		),
		
		aCARD_ADD => array(
			'tekst' => '',
			'controller' => 'cards',
			'action' => 'add',
			'class' => 'caadd'
		),
		aCARD_LIST => array(
			'tekst' => '',
			'controller' => 'cards',
			'action' => 'index',
			'class' => 'calist'
		),
		
		aORD_ADD => array(
			'tekst' => '',
			'controller' => 'orders',
			'action' => 'add',
			'class' => 'ordadd'
		),
		aORD_LIST => array(
			'tekst' => '',
			'controller' => 'orders',
			'action' => 'index',
			'class' => 'ordlist'
		),
		
		aJOB_ADD => array(
			'tekst' => '',
			'controller' => 'jobs',
			'action' => 'add',
			'class' => 'jobadd'
		),
		aJOB_LIST => array(
			'tekst' => '',
			'controller' => 'jobs',
			'action' => 'index',
			'class' => 'joblist'
		)
	);
	
	
	public function displayActions( $kontroler = null ) {
		
		$cntab = [
			'customers' => 'klienci',
			'cards' => 'karty',
			'orders' => 'zamowienia',
			'jobs' => 'zlecenia'
		];
		
		
		echo $this->Html->tag('div', null, array('id'=>'gener', 'class' => 'actions'));
		echo $this->Html->tag('ul', null, array('class' => 'ble'));
		
		
		foreach( $cntab as $key => $value ) {
			if( $kontroler == $key )
				$options = array('class' => $value, 'id' => 'aktywny');
			else
				$options = array('class' => $value);
			
			$klucz = $key;
			switch( $key )	{
				case 'cards':
					$par = 'active';
				break;
				case 'orders':
					$par = 'active';
				break;
				case 'jobs':
					if( AuthComponent::user('O_KOR') ) {
						$par = 'started';
					} else {
						$par = 'active';
					}                                        
				break;
				case 'customers':
					$par = null;
					$klucz = 'webixes';
				break;
				default:
					$par = null;
			}
				
			if( $key == 'customers' ) {
                $theTab = '/klienci/dodaj';
				$l2 = $this->Html->link(
					'',
					'/klienci',
					array('class' => 'list2')
				);
			} else {
                $theTab = array( 'controller' => $key, 'action' => 'add');				
				$l2 = $this->Html->link(
					'',
					array( 'controller' => $klucz, 'action' => 'index', $par),
					array('class' => 'list2')
				);
			}
			$l1 = $this->Html->link(
				'',
				$theTab,
				array('class' => 'add2')
			);
			
			echo $this->Html->tag('li', $l1.$l2, $options);
		}
				
		echo $this->Html->tag('/ul');/**/
		echo $this->Html->tag('/div');
	}
	
	
	
	public function displayActions_old( $links2print = array() ) {
		
		echo $this->Html->tag('div', null, array('id'=>'gener', 'class' => 'actions'));
		echo $this->Html->tag('ul', null, array('class' => 'ble'));
		$prev = 0;
		foreach( $links2print as $key => $value ) {
		 
		 if( $value > 0 ) {
		 				
			echo $this->Html->tag('li');
			if(  array_key_exists ('class', $this->link_tab[$value]) )
				$class = $this->link_tab[$value]['class'];
			else
				$class = null;
			echo $this->Html->link( $this->link_tab[$value]['tekst'],
					array(
						'controller' => $this->link_tab[$value]['controller'],
						'action' => $this->link_tab[$value]['action']
						),
					array('class' => $class)
			);
			echo $this->Html->tag('/li');
			
			$prev =	$value;			
		
		 }	
				
		}
		echo $this->Html->tag('/ul');/**/
		echo $this->Html->tag('/div');
	}
	
	//sprawdza czy karta ma jakies opcje sita, argument musi byc
	//tablicą z polami karty z bazy
	public function is_sito($cardarr = array()) {
		return true;	
	}
	//###### wspomagnie wiew
	public $card_view = array(
		'x_podpis' => array(
			'view' =>  array(
				BRAK	=>	'BRAK',	
				TRAN	=>	'PRZEŹROCZ.', //Pasek do podpisu - przeźroczysty
				BIAL	=>	'BIAŁY'
			)
		)
	);
	
	public function nawiguj( $links = array(), $id = null ) {
		
		if( !empty($links) ) {
			
			echo $this->Html->tag('div', null, array('id'=>'bleble', 'class' => 'nawigdiv'));
			
				foreach( $links as $key => $value ) {
					switch($value) {
							case nCARD_ADD:
							echo $this->Html->link( '',	array(
									'controller' => 'cards',
									'action' => 'add' ),
									array('class' => 'nawigbutt', 'id' => 'plus')
							);
							break;
						case nCARD_DEL:
							echo $this->Form->postLink('', array(
									//'controller' => 'orders',
									'action' => 'delete', $id ),
									array('class' => 'nawigbutt', 'id' => 'kosz'),
									__('Na pewno chcesz usunąć kartę id: %s?', $id )
							);
							break;
							/*echo $this->Form->postLink(__('Delete'), array(
									'action' => 'delete', $order['Order']['id']),
									null,
									__('Are you sure you want to delete # %s?', $order['Order']['id']));*/
						case nCARD_EDIT:
							//echo $this->Html->div('nawigbutt', '', array('id' => 'edytuj'));
							echo $this->Html->link( '',	array(
									'controller' => 'cards',
									'action' => 'edit', $id ),
									array('class' => 'nawigbutt', 'id' => 'edytuj')
							);
							break;
						case nCARD_LIST:
							echo $this->Html->link( '',	array(
									'controller' => 'cards',
									'action' => 'index' ),
									array('class' => 'nawigbutt', 'id' => 'list')
							);
							break;
						case nORD_ADD:
							echo $this->Html->link( '',	array(
									'controller' => 'orders',
									'action' => 'add' ),
									array('class' => 'nawigbutt', 'id' => 'plus')
							);
							break;
						case nORD_DEL:
							echo $this->Form->postLink('', array(
									//'controller' => 'orders',
									'action' => 'delete', $id ),
									array('class' => 'nawigbutt', 'id' => 'kosz'),
									__('Na pewno chcesz usunąć zamówienie id: %s?', $id )
							);
							break;
							/*echo $this->Form->postLink(__('Delete'), array(
									'action' => 'delete', $order['Order']['id']),
									null,
									__('Are you sure you want to delete # %s?', $order['Order']['id']));*/
						case nORD_EDIT:
							//echo $this->Html->div('nawigbutt', '', array('id' => 'edytuj'));
							echo $this->Html->link( '',	array(
									'controller' => 'orders',
									'action' => 'edit', $id ),
									array('class' => 'nawigbutt', 'id' => 'edytuj')
							);
							break;
						case nORD_LIST:
							echo $this->Html->link( '',	array(
									'controller' => 'orders',
									'action' => 'index' ),
									array('class' => 'nawigbutt', 'id' => 'list')
							);
							break;
						case nCUS_ADD:
							echo $this->Html->link( '',	array(
									'controller' => 'customers',
									'action' => 'add' ),
									array('class' => 'nawigbutt', 'id' => 'plus')
							);
							break;
						case nCUS_DEL:
							echo $this->Form->postLink('', array(
									//'controller' => 'orders',
									'action' => 'delete', $id ),
									array('class' => 'nawigbutt', 'id' => 'kosz'),
									__('Na pewno chcesz usunąć klienta id: %s?', $id )
							);
							break;							
						case nCUS_EDIT:
							//echo $this->Html->div('nawigbutt', '', array('id' => 'edytuj'));
							echo $this->Html->link( '',	array(
									'controller' => 'customers',
									'action' => 'edit', $id ),
									array('class' => 'nawigbutt', 'id' => 'edytuj')
							);
							break;
						case nCUS_LIST:
							echo $this->Html->link( '',	array(
									'controller' => 'customers',
									'action' => 'index' ),
									array('class' => 'nawigbutt', 'id' => 'list')
							);
							break;
						
					}
				}
				
			echo $this->Html->tag('/div');
			
		}
	}
	
	public function viewheader( $tekst = '', $attribs = array()) {
	// wyświetla niebieski nagłówek, p tag w widokach
	// $tekst - tekst do wyświetlenia
	// $attribs - dodatkowe atrybuty html
		
		if( !empty($attribs) ) {
			$atrybuty = $attribs;
			
			if( array_key_exists('class', $attribs) ) 
				$atrybuty['class'] = 'viewheader ' . $attribs['class'];
			else
				$atrybuty['class'] = 'viewheader';			
		}
		else
			$atrybuty = array('class' => 'viewheader');
		return $this->Html->tag('p', $tekst, $atrybuty );
			
	}
	
	// ### CARD VIEWS SPECYFIC
	
	
	// CARD ADD
	public function make_cmyk($vju = array()) {
		
		$material = array('materiał',
			$this->Form->input('Card.a_material',$vju['x_material']),
			$this->Form->input('Card.r_material',$vju['x_material'])
		);
		$laminat = array('laminat',
			$this->Form->input('Card.a_lam',$vju['x_lam']),
			$this->Form->input('Card.r_lam',$vju['x_lam'])
		);
		$cmyk = array('cmyk',
			$this->Form->input('Card.a_c',$vju['x_c']).
			$this->Form->input('Card.a_m',$vju['x_m']).
			$this->Form->input('Card.a_y',$vju['x_y']).
			$this->Form->input('Card.a_k',$vju['x_k']),
			
			$this->Form->input('Card.r_c',$vju['x_c']).
			$this->Form->input('Card.r_m',$vju['x_m']).
			$this->Form->input('Card.r_y',$vju['x_y']).
			$this->Form->input('Card.r_k',$vju['x_k'])
		);
		$panton = array('pantony',
			$this->Form->input('Card.a_pant',$vju['x_pant']),
			$this->Form->input('Card.r_pant',$vju['x_pant'])
		);
		$tablica = array( $material, $laminat, $cmyk, $panton );
		
		
		
		$markup =	$this->Html->tag('div', null, array('class' => 'cmykdiv')) .
					$this->Html->tag('table') .
					$this->Html->tableHeaders(array('', 'awers','rewers')) .
					$this->Html->tableCells($tablica) . $this->Html->tag('/table') .
					$this->Html->tag('/div') .
					$this->Form->input('Card.cmyk_comment', $vju['cmyk_comment']);
		
		return $markup;
	}


	public function make_sito($vju = array()) {
		
		$podklad = array('podkład',
			$this->Form->input('Card.a_podklad',$vju['x_sito']),
			$this->Form->input('Card.r_podklad',$vju['x_sito'])
		);
		$wybranie = array(
			array( 'wybranie', array('class' => 'innawybroza')),
			array( $this->Form->input('Card.a_wybr',$vju['yesno']), array('class' => 'wybroza')),
			array( $this->Form->input('Card.r_wybr',$vju['yesno']), array('class' => 'wybroza'))
		);
		$zadruk = array('zadruk',
			$this->Form->input('Card.a_zadruk',$vju['x_sito']),
			$this->Form->input('Card.r_zadruk',$vju['x_sito'])
		);
		$pasek = array('pasek do podpisu',
			$this->Form->input('Card.a_podpis',$vju['x_podpis']),
			$this->Form->input('Card.r_podpis',$vju['x_podpis'])
		);
		$zdrapka = array('zdrapka',
			$this->Form->input('Card.a_zdrapka',$vju['yesno']),
			$this->Form->input('Card.r_zdrapka',$vju['yesno'])
		);
		$lakierP = array('lakier puchnący',
			$this->Form->input('Card.a_lakpuch',$vju['yesno']),
			$this->Form->input('Card.r_lakpuch',$vju['yesno'])
		);
		$lakierB = array('lakier błyszczący',
			$this->Form->input('Card.a_lakblys',$vju['yesno']),
			$this->Form->input('Card.r_lakblys',$vju['yesno'])
		);
		// lakier matowy
		$lakierM = ['lakier matowy',
			$this->Form->input('Card.a_lakmat',$vju['yesno']),
			$this->Form->input('Card.r_lakmat',$vju['yesno'])
		];
		
		
		$tablica = array( 
					$podklad, $wybranie, $zadruk, $pasek, $zdrapka,
					$lakierP, $lakierB, $lakierM );
		
		$markup =	$this->Html->tag('div', null, array('class' => 'sitodiv')) .
					$this->Html->tag('table', null, array('class' => 'sitotable')) .
					$this->Html->tableHeaders( array('', 'awers','rewers')) .
					$this->Html->tableCells($tablica) .
					$this->Html->tag('/table') .
					$this->Html->tag('/div') .
					$this->Form->input('Card.sito_comment',$vju['sito_comment']);
	
		return $markup;
	}

	public function make_options( $vju = array() ) {
		
            $markup =
                $this->Html->tag('div', null, array('class' => 'optiondiv')) .
                        $this->Form->input('Card.mag',$vju['mag']) .
                        $this->Form->input('Card.wzor',$vju['wzor']) .
                        $this->Form->input('Card.chip',$vju['chip']) .
                        $this->Form->input('Card.ishotstamp', $vju['hotstamp']) .
                $this->Html->tag('/div') .
                $this->Html->tag('div', null, array('class' => 'optiondiv')) .
                        $this->Form->input('Card.dziurka',$vju['dziurka']) .
                        $this->Form->input('Card.ksztalt',$vju['ksztalt']) .
                        $this->Form->input('Card.hologram',$vju['hologram']) .
                        //$this->Form->input('Card.etylang', $vju['etylang']) .
                $this->Html->tag('/div') .
                $this->Html->tag('div', null, array('class' => 'optiondiv')) .
                        $this->Form->input('Card.option_comment',$vju['option_comment']) .
                $this->Html->tag('/div');
            return $markup;
	}
	
	
	public function make_perasoAndFcomment( $vju = array() ) {
		
		// Dodatkowe pole input do wpisywania stanu na magazyn
		$theLeftInput = $this->Form->input('Card.left', [
			'label' => false,
			'div' => false,
			'min' => 0,
			'placeholder' => 'na magazyn'
		]);		

		$markup =	

			$this->Html->tag('div', null, array('id' => 'persokeep')) .
					$this->viewheader("PERSONALIZACJA$theLeftInput", ['id' => 'nag-perso', 'class' => 'dol_very_small']) .
					$this->Form->hidden( 'Card.isperso', array('default' => '0') ) .
					$this->Html->tag('div', null, array('id' => 'xyz123', 'class' => 'perso-types')) .
						$this->Form->input('Card.pl', array( 'label' => 'pod laminat' )) .
						$this->Form->input('Card.pt', array( 'label' => 'płaska' )) .
						$this->Form->input('Card.pe', array( 'label' => 'embossing' )) .
					$this->Html->tag('/div') .
					$this->Form->input('Card.perso', $vju['perso']) .
			$this->Html->tag('/div') .
			$this->Html->tag('div', null, array('id' => 'finaluw', 'class' => 'input textarea')) .
					$this->viewheader('UWAGI DO CAŁEGO PROJEKTU', array('class' => 'dol_small')) .
					$this->putEtykieta($vju) .
					$this->Form->input('Card.comment',$vju['comment']) .
			$this->Html->tag('/div');
				
		
		return $markup;
	}
        
        private function putEtykieta( $vju ) {
            
            return
                $this->Html->tag('div', null, array('id' => 'etykietoza')) .
                    $this->Form->input('Card.etykieta', $vju['etykieta']) . 
                    $this->Form->input('Card.etylang', $vju['etylang']) .
                $this->Html->tag('/div');
            
        }

	
	public function zalaczone_pliki( $pliczki = array(), $thevju = array() ) {
		
		$markup = null;
		if ( !empty($pliczki) ) {
			
			$i=0; $trs = null;
			foreach($pliczki as $value) {
				
				$rolearr = $thevju['role'];
				unset($rolearr['options'][NULL]);
				$roletxtarr = $thevju['roletxt'];

				$rodo_checkbox = $this->Form->input('Zalaczone.'.$i.'.rodo', array(
									'type' => 'checkbox', 'label' => false, 'div' => false,							
									'checked' => $value['rodo'] 
				));

				$rolearr['default'] = $value['role'];
				$role_select = $this->Form->input('Zalaczone.'.$i.'.role', $rolearr);
				

				$trs .= '<tr><td>' . 
						$this->Form->hidden('Zalaczone.'.$i.'.id', array('default' =>  $value['id'])) .
						$this->Form->input( 'Zalaczone.'.$i.'.taken', array(
							 'type' => 'checkbox', 'label' => false, 'div' => false,
							 //'klid' => $value['customer_id'],
							 'checked' => true ))	. 							 
						'</td>';
				$trs .= '<td>' . $this->Html->link( $value['filename'], array('controller' => 'uploads', 'action' => 'download', $value['id'] ) ) . '</td>';

				$trs .= "<td class=\"rodo_box\">$rodo_checkbox</td>";

				$trs .= "<td class=\"role\">$role_select</td>";

				//$trs .= '<td></td></tr>';
				if( $value['role'] != OTHER_ROLE ) 
					$roletxtarr['disabled'] = true;
				else {
					$roletxtarr['required'] = true;
					$roletxtarr['default'] = $value['roletxt'];
				}
				$trs .= '<td>' . $this->Form->input('Zalaczone.'.$i++.'.roletxt', $roletxtarr) . '</td></tr>';
								
			}
			
			
			$markup =	$this->Html->tag('div', null, array('id' => 'zdiv')) .
						//$this->Html->tableHeaders(array('Id', 'Nazwa Pliku', 'Przeznaczenie', 'Rozmiar')) .
						$this->Html->tag('label', 'PLIKI DOŁĄCZONE DO TEJ KARTY:') .
						$this->Html->tag('table', null, array('id' => 'zpliki')) .
							"<tr><th></th><th></th><th class=\"rodo_box\">RODO</th><th class=\"role\"></th><th></th></tr>" .
							$trs .	
							$this->Html->tag('/table') .
						$this->Html->tag('/div');
		} 
		
		return $markup;
		
	}

	/*
		Usuń ze wspólnych pliki załączone do karty - używane przy edycji
	*/
	public function oczysc_wspolne($wspolne = array(), $zalaczane = array()) {
		
		$oczyszczone = array();
		foreach($wspolne as $value) {
			$idpliku = $value['id'];
			$niema = true;
			foreach($zalaczane as $war) {
				if( $war['id'] == $idpliku )
					$niema = false;
			}
			if( $niema )
				$oczyszczone[] = $value;
		}
		
		return $oczyszczone;
	}

	public function wspolne_pliki( $wspolne = array(), $edit = false ) {
		
		$markup = null;
		if ( !empty($wspolne) ) {
						
			$i=0; $trs = null;
			foreach($wspolne as $value) {
				$trs .= '<tr class="cu' . $value['customer_id'] . '"><td>';
				$trs .= $this->Form->input( 'Wspolne.'.$i.'.taken', array(
							 'type' => 'checkbox', 'label' => false, 'div' => false,
							 'klid' => $value['customer_id'],
							 'checked' => false ))	. 
							 $this->Form->hidden('Wspolne.'.$i++.'.id', array('default' =>  $value['id'])) .
							 '</td>';
				$trs .= '<td>' . $this->Html->link( $value['filename'],	array(
							'controller' => 'uploads', 'action' => 'download', $value['id'] )) . '</td>';
				$trs .= '<td class="role">' . $value['roletxt'] . '</td>';
				$trs .= '<td>' . $value['cardname'] . '</td></tr>';
				
				//unset( $wspolne[$i++]['customer_id'] );
			}
			$klasa = $edit ? "th" : "";
			$markup =	$this->Html->tag('div', null, array('id' => 'wdiv')) .
							$this->Html->tag('label', 'PLIKI DODANE WCZEŚNIEJ Z INNYMI KARTAMI:') .
							$this->Html->tag('table', null, array('id' => 'wpliki')) .
							"<tr class=$klasa><th></th><th></th><th class=\"role\"></th><th>Karta</th></tr>" .
								$trs .	
							$this->Html->tag('/table') .
						$this->Html->tag('/div');
		}
		return $markup;	
		
		
	}

	public function indexFiltry( $kontroler = null, $klasa = array() ) {
		
            switch($kontroler) {
                case 'orders':
                        $retcode =  '<p class="filtry">'.
                                $this->Html->link( 'moje', array( 'controller' => 'orders', 'action' => 'index', 'my'), array('class' => $klasa['my'])) .
                                $this->Html->link( 'przyjęte', array( 'controller' => 'orders', 'action' => 'index', 'accepted'), array('class' => $klasa['accepted'])) .
                                $this->Html->link( 'odrzucone', array( 'controller' => 'orders', 'action' => 'index', 'rejected'), array('class' => $klasa['rejected'])) .
                                $this->Html->link( 'do sprawdzenia', array( 'controller' => 'orders', 'action' => 'index', 'wait4check'), array('class' => $klasa['wait4check'])) .
                                $this->Html->link( 'aktywne', array( 'controller' => 'orders', 'action' => 'index', 'active'), array('class' => $klasa['active'])) .
								$this->Html->link( 'zakończone', array( 'controller' => 'orders', 'action' => 'index', 'closed'), array('class' => $klasa['closed'])) .
								$this->Html->link( 'wszystkie', array( 'controller' => 'orders', 'action' => 'index'), array('class' => $klasa['wszystkie'])) .
								$this->Html->link( 'na dziś +', array( 'controller' => 'orders', 'action' => 'index', 'today'), array('class' => $klasa['today'])) .	
								$this->Html->link( 'serwis', array( 'controller' => 'orders', 'action' => 'index', 'serwis'), array('class' => $klasa['serwis'])) .	                                
                                '</p>';
                break;
                case 'cards':
                        $retcode =
                        '<p class="filtry">'.
                            $this->Html->link( 'DTP?', array( 'controller' => 'cards', 'action' => 'index', 'dtpcheck'), array('class' => $klasa['dtpcheck'])) .
							//$this->Html->link( 'HOT', array( 'controller' => 'cards', 'action' => 'index', 'hot'), array('class' => $klasa['hot'])) .
                            $this->Html->link( 'PERSO?', array( 'controller' => 'cards', 'action' => 'index', 'persocheck'), array('class' => $klasa['persocheck'])) .

                            $this->Html->link( 'P-ONLY', array( 'controller' => 'cards', 'action' => 'index', 'ponly'), array('class' => $klasa['ponly'])) .
                            $this->Html->link( 'P-TODO', array( 'controller' => 'cards', 'action' => 'index', 'ptodo'), array('class' => $klasa['ptodo'])) .
                            $this->Html->link( 'P-JUŻ', array( 'controller' => 'cards', 'action' => 'index', 'pover'), array('class' => $klasa['pover'])) .

                            $this->Html->link( 'aktywne', array( 'controller' => 'cards', 'action' => 'index', 'active'), array('class' => $klasa['active'])) .							
                            $this->Html->link( 'zakończone', array( 'controller' => 'cards', 'action' => 'index', 'closed'), array('class' => $klasa['closed'])) .
                            $this->Html->link( 'wszystkie', array( 'controller' => 'cards', 'action' => 'index', 'all-but-priv'), array('class' => $klasa['all-but-priv'])) .
                            $this->Html->link( 'moje', array( 'controller' => 'cards', 'action' => 'index', 'my'), array('class' => $klasa['my'])) .
                        '</p>';
                break;
                case 'jobs':
                    // filtr tylko widoczny przez koordynatora
                    if( AuthComponent::user('O_KOR') ) {
                        $kor_filtr = $this->Html->link( 'startujące', array( 'controller' => 'jobs', 'action' => 'index', 'started'), array('class' => $klasa['started'])); }
                    else { $kor_filtr = null; }
                    $retcode =  
                        '<p class="filtry">'. $kor_filtr .
                        $this->Html->link( 'aktywne', array( 'controller' => 'jobs', 'action' => 'index', 'active'), array('class' => $klasa['active'])) .							
                        $this->Html->link( 'zakończone', array( 'controller' => 'jobs', 'action' => 'index', 'closed'), array('class' => $klasa['closed'])) .
                        $this->Html->link( 'wszystkie', array( 'controller' => 'jobs', 'action' => 'index', 'all-but-priv'), array('class' => $klasa['all-but-priv'])) .
                        '</p>';
                break;
                default:
                 $retcode = null;
            }
            return $retcode;
	}
        
        
        public function adresDostawy( $zamowienie = array() ) {
            
            $msg = null;
            switch( $zamowienie['Order']['sposob_dostawy'] ) {
                    case OO:
                            $msg = 'ODBIÓR OSOBISTY';
                    break;
                    case PAU:
                            $msg = 'PATRZ UWAGI';
                    break;
                    case IA:
                            $msg =	$zamowienie['AdresDostawy']['name'] . "\nul. " .
                                            $zamowienie['AdresDostawy']['ulica'] .' ' .
                                            $zamowienie['AdresDostawy']['nr_budynku'] . "\n" .
                                            $zamowienie['AdresDostawy']['kod'] . ', ' . 
                                            $zamowienie['AdresDostawy']['miasto'] . "\n" .
                                            $zamowienie['AdresDostawy']['kraj']; 
                    break;
                    case NAF:
                            $msg = 'NA ADRES FAKTURY';
                            if( $zamowienie['Order']['siedziba_id'] != $zamowienie['Order']['wysylka_id'] )
                                    $msg .= ' (błąd)';
                    break;
                    default:
                            $msg = 'coś nie tak';
            }	
            
            return nl2br($msg);            
        }
        
        public function adresFaktury( $zamowienie ) {
            
            $msg = $zamowienie['AdresDoFaktury']['name'] . "\nul. " .
                $zamowienie['AdresDoFaktury']['ulica'] .' ' .
                $zamowienie['AdresDoFaktury']['nr_budynku'] . "\n" .
                $zamowienie['AdresDoFaktury']['kod'] . ', ' . 
                $zamowienie['AdresDoFaktury']['miasto'] . "\n" .
                $zamowienie['AdresDoFaktury']['kraj'];
            return nl2br($msg);            
        }
        
    public function makeTableFromSearch( $rodzaj = null, $dane_tab = array() ) {
        
        switch( $rodzaj ) {
            case 'klienci':
                return $this->sirczKlienciTabela($dane_tab );
            case 'karty':
                return $this->sirczKartyTabela($dane_tab );
            case 'zamowienie':
                return $this->sirczZamowienieTabela($dane_tab );
            case 'zlecenie':
                return $this->sirczZlecnieTabela($dane_tab );
            default:
                return null;
        }       
    }
    
    
    
    private function sirczKlienciTabela( $tablica_danych = array() ) {
        
        $tablica = array(); $i = 0;
        foreach( $tablica_danych as $element) {
            $nazwa = array(
                $this->Html->link( $element['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $element['Customer']['id'])),
                array( 'class' => 'nazwa' )
            );
            $opiekun = array( $element['Owner']['name'], array( 'class' => 'opiekun' ));
            $wiersz = array( array(++$i, array( 'class' => 'lp' )), $nazwa, $opiekun  );
            $tablica[] = $wiersz;
        }
        return '<table>' . 
                $this->Html->tableHeaders(array(
                    array('Lp.' => array('class' => 'lp')),
                    array('Nazwa' => array('class' => 'nazwa')),
                    array('Opiekun' => array('class' => 'opiekun'))/*,
                    array('Handlowe' => array('class' => 'handlowe')),
                    array('Produk.' => array('class' => 'produkcyjne')),
                    array('Termin' => array('class' => 'data'))*/
                )) . $this->Html->tableCells($tablica) .
                '</table>';
    }
    
    private function sirczZlecnieTabela( $tablica_danych = array() ) {
     
        $numer = array(
                $this->Html->link( $this->bnr2nrj( $tablica_danych['Job']['nr'], null ), array('controller' => 'jobs', 'action' => 'view', $tablica_danych['Job']['id']), array('escape' => false)),
                array( 'class' => 'zamnr' )
        );
        $data = array(
                $this->md($tablica_danych['Job']['stop_day'], true),
                array( 'class' => 'data' )
        );
        $karty = null; $i = 1;
        if( count($tablica_danych['Card']) > 1 ) {
            $po = '<p>'; $pc = '</p>'; $lp = '1. ';
        } else {
            $po = $pc = $lp = null;
        }
        foreach( $tablica_danych['Card'] as $karta ) {
          $karty .= $po . $lp . $this->Html->link(
                    $karta['name'],
                    array('controller' => 'cards', 'action' => 'view', $karta['id'])
                  ) . $pc;  
          $lp = ++$i . '. ';
        }
        $tablica = array( array( $numer, $karty, $data) );
        return '<table>' . 
                $this->Html->tableHeaders(array(
                    array('Numer' => array('class' => 'zamnr')),
                    'Karty',
                    array('Termin' => array('class' => 'data'))
                )) . $this->Html->tableCells($tablica) .
                '</table>';
    }
    
    private function sirczZamowienieTabela( $tablica_danych = array() ) {
        
        $numer = array(
                $this->Html->link( $this->bnr2nrh($tablica_danych['Order']['nr'], $tablica_danych['User']['inic']), array('controller' => 'orders', 'action' => 'view', $tablica_danych['Order']['id']), array('escape' => false)),
                array( 'class' => 'zamnr' )
        );
        $data = array(
                $this->md($tablica_danych['Order']['stop_day'], true),
                array( 'class' => 'data' )
        );
        $karty = null; $i=1;
        if( count($tablica_danych['Card']) > 1 ) {
            $po = '<p>'; $pc = '</p>'; $lp = '1. ';
        } else {
            $po = $pc = $lp = null;
        }
        foreach( $tablica_danych['Card'] as $karta ) {
          $karty .= $po . $lp  . $this->Html->link(
                    $karta['name'],
                    array('controller' => 'cards', 'action' => 'view', $karta['id'])
                  ) . $pc;  
          $lp = ++$i . '. ';
        }
        $tablica = array( array( $numer, $karty, $data) );
        return '<table>' . 
                $this->Html->tableHeaders(array(
                    array('Numer' => array('class' => 'zamnr')),
                    'Karty',
                    array('Termin' => array('class' => 'data'))
                )) . $this->Html->tableCells($tablica) .
                '</table>';
    }
    
    private function sirczKartyTabela( $tablica_danych = array() ) {
        
        $tablica = array(); $i = 0;
        foreach( $tablica_danych as $element) {
            $nazwa = array(
                $this->Html->link( $element['Card']['name'], array('controller' => 'cards', 'action' => 'view', $element['Card']['id'])),
                array( 'class' => 'nazwa' )
            );
            $klient = array(
                $this->Html->link( $element['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $element['Customer']['id'])),
                array( 'class' => 'klient' )
            );
            $zamowienie = array(
                $this->Html->link( $this->bnr2nrh($element['Order']['nr'], $element['Creator']['inic']), array('controller' => 'orders', 'action' => 'view', $element['Order']['id']), array('escape' => false)),
                array( 'class' => 'handlowe' )
            );
            $zlecenie = array(
                $this->Html->link( $this->bnr2nrj( $element['Job']['nr'], null ), array('controller' => 'jobs', 'action' => 'view', $element['Job']['id']), array('escape' => false)),
                array( 'class' => 'produkcyjne' )
            );
            $data = array(
                $this->md($element['Order']['stop_day'], true),
                array( 'class' => 'data' )
            );
            $wiersz = array( array(++$i, array( 'class' => 'lp' )), $nazwa, $klient, $zamowienie, $zlecenie, $data);
            $tablica[] = $wiersz;
        }
        return '<table>' . 
                $this->Html->tableHeaders(array(
                    array('Lp.' => array('class' => 'lp')),
                    array('Nazwa' => array('class' => 'nazwa')),
                    array('Klient' => array('class' => 'klient')),
                    array('Handlowe' => array('class' => 'handlowe')),
                    array('Produk.' => array('class' => 'produkcyjne')),
                    array('Termin' => array('class' => 'data'))
                )) . $this->Html->tableCells($tablica) .
                '</table>';
    }
    
    public function relatedCustomerOrders($zamowienia = array(), $karty = array(), $inicjaly = array()) {
    // W widoku klienta chcemy mieć listę jego zamówień 
        
        $tds = array();
        foreach( $zamowienia as $zam ) {
            $nr = array( 
                $this->Html->link(
                    $this->bnr2nrh($zam['nr'], $inicjaly[$zam['user_id']]),
                    array( 'controller' => 'orders', 'action' => 'view', $zam['id']),
                    array('escape' => false)    
                ),
                array('class' => 'numer')
            );
            $cards = array($this->listOfCardsForTheOrder( $zam['id'], $karty ), array('class' => 'karty'));
            $stop = array( $this->md($zam['stop_day']), array('class' => 'data'));
            $tds[] = array($nr, $cards, $stop);
        }
        
        $r_orders = '<table>' .
        $this->Html->tableHeaders(array(
                        array('numer' => array('class' => 'numer')),
                        array('karty' => array('class' => 'karty')),
                        array('termin' => array('class' => 'data'))
        )) .
        $this->Html->tableCells($tds) .
        '</table>';
        return $r_orders;
    }

    private function listOfCardsForTheOrder( $zam_id = null, $karty = array() ) {
        
        $allcards = array(); $j = 0;
        foreach( $karty as $karta ) {
            if( $karta['order_id'] == $zam_id ) {
                $allcards[] = array( 'id' => $karta['id'] ,'name' => $karta['name'] );                
            }  
            $j++;
            if( $j > 0 ) { break; }
        }
        if( count($allcards) > 1 ) {
            $str = null; $i = 1;
            foreach( $allcards as $item) {
                $str .= $i . '. ' .
                        $this->Html->link($item[$i-1]['name'], array(
                            'controller' => 'cards',
                            'action' => 'view',
                            $item[$i-1]['id']
                        )) . '<br>';
                $i++;
            }
            return $str;
        } else {
            return $this->Html->link($allcards[0]['name'], array(
                  'controller' => 'cards',
                  'action' => 'view',
                  $allcards[0]['id']
                ));
        }
        
    }
    
    public function stanPersoChange( $karta = array('isperso' => 0) ) {
    // sprawdzamy czy stan karty nadaje się do zmieninania karty
        if( $karta['isperso'] || $karta['ishotstamp'] ) { // ma wogóle perso
          if( $karta['status'] != PRIV && $karta['status'] != KONEC ) {
              return true;
          } 
        }
        return false;
    }
	
}



