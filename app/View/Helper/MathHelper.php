<?php

/**
 * Przeliczanie różnych rzeczy
 *
 * @author dexter
 */

App::uses('AppHelper', 'View/Helper');

class MathHelper extends AppHelper {
    
    public $helpers = array('Number');
    
    public $mies_full = array(
		'01' => 'styczeń',
		'02' => 'luty',
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
    
    public function tys($nr) { // ładne odstępy przy tysiącach
        return $this->Number->format($nr, array(
                'places' => 0, 'before' => null, 'thousands' => ' '));
    }
    
}



