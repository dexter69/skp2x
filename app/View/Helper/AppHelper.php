<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {
    
    //MATERIAŁ KART
    public $material_kart = array(
        'short1' => array(
            PVC => 'PVC',
            BIO => 'BIO',
            TRA => 'TRA',
            KOL => 'KOL',
            FOL => 'FOL',
            OPVC => 'INNY'
        ),
        'long1' => array(
            PVC => 'STANDARD PVC',
            BIO => 'BIO PVC',
            TRA => 'TRANSPARENT',
            KOL => 'KOLOR PVC',
            FOL => 'PVC FOLIĄ',
            OPVC => 'INNY'
        )
    );
    
    //FARBY NA SITO
    public $farby_na_sito = array(
        'short1' =>  array (
                        0	=>	'-',	//nie ma podkładu z sita
                        S3	=>	'S303',
                        Z2	=>	'Z3002',
                        Z3	=>	'Z3003',
                        P3	=>	'P38001',
                        P4	=>	'P44001',
                        BI      =>      'BIAŁE',
                        IN	=>	'INNY'	//inny kolor - uwagi
                    ),
        'long1' =>  array (
                        0	=>	'BRAK',	//nie ma podkładu z sita
                        S3	=>	'SREBRO 303',
                        Z2	=>	'ZŁOTO 3002',
                        Z3	=>	'ZŁOTO 3003',
                        P3	=>	'PERŁA 38001',
                        P4	=>	'PERŁA 44001',	
                        BI      =>      'BIAŁE',
                        IN	=>	'INNY'	//inny kolor - uwagi
                    )
    );
    
    public $wybranie = '<span class="nozyczki1 pdf-symbol"></span>';
    //public $wybranie = '<span class="glyph-nozyczki pdf-symbol"></span>';
    //public $brak = '<span class="nie-brak-x pdf-symbol"></span>'; fajny 'x' graficzny
    public $brak = '-';
    /* fajny graficzny ptaszek
    public $yes = '<span class="tak-checked pdf-symbol"></span>';
    public $bigyes = '<span class="tak-checked pdf-symbol-big"></span>';
    */
    public $yes = '+';
    public $bigyes = '+';
    
    
    //CMYK    
    public $cmyk = array(
        'C' => array(0 => '-', 1 => 'C'),
        'M' => array(0 => '-', 1 => 'M'),
        'Y' => array(0 => '-', 1 => 'Y'),
        'K' => array(0 => '-', 1 => 'K')
    );
    
    //LAMINAT
    public $laminat = array(
        'short1' =>  array (
                        BRAK    =>      'BRAK', // karty bez laminatu
                        BL	=>	'BŁYS',	// LAMINAT BŁYSZCZĄCY
                        GL	=>	'GŁAD', // LAMINAT GŁADKI
                        CH	=>	'CHRO' // LAMINAT CHROPWATY
                    ),
        'long1' =>  array (
                        BRAK    =>      'BRAK', // karty bez laminatu
                        BL	=>	'BŁYSZCZĄCY',	// LAMINAT BŁYSZCZĄCY
                        GL	=>	'GŁADKI', // LAMINAT GŁADKI
                        CH	=>	'CHROPOWATY' // LAMINAT CHROPWATY
                    )
    );
    
    //Pasek mag.
    public $mag = array(
        'short1' =>  array (
                        0	=>	'-',    // Brak
                        HICO	=>	'Hi',   // HiCo
                        LOCO	=>	'Lo'    // LoCo
                    ),
        'short2' =>  array (
                        0	=>	'-',    // Brak
                        HICO	=>	'HiCo',   // HiCo
                        LOCO	=>	'LoCo'    // LoCo
                    ),
        'long1' =>  array (
                        0	=>	'BRAK',    // Brak
                        HICO	=>	'HiCo',   // HiCo
                        LOCO	=>	'LoCo'    // LoCo
                    )
    );
    
    //Sito po
    public $sipo = array(
        'short1' =>  array (
                        'lbly' => array(0 => null, 1 => 'LB'),
                        'lpuch' => array(0 => null, 1 => 'LP'),
                        'zdra' => array(0 => null, 1 => 'ZD')
                    ),
        'short2' =>  array (
                        'lbly' => array(0 => null, 1 => 'LAK BŁYS'),
                        'lpuch' => array(0 => null, 1 => 'LAK PUCH'),
                        'zdra' => array(0 => null, 1 => 'ZDRAP')
                    )
    );
    
    // Pasek do podpisu
    public $pasek = array(
        'short1' => array(
                        BRAK	=>	'-',	
                        TRAN	=>	'TRA', //Pasek do podpisu - przeźroczysty
                        BIAL	=>	'BIA', //Pasek do podpisu - biały
                    ),
        'long1' => array(
                        BRAK	=>	'BRAK',	
                        //'1' =>	'INNY', /* zarezerwowane */
                        TRAN	=>	'PRZEŹROCZ.', //Pasek do podpisu - przeźroczysty
                        BIAL	=>	'BIAŁY', //Pasek do podpisu - biały
                    ),
    
    );
    
    //Status zamówienia (orders)
    public $order_stat = array(
        PRIV => 'PRYWATNE',
        NOWKA => 'NOWE',
        O_ERR => 'SPRAWDZANIE',
        O_FINE => 'SPRAWDZANIE',
        O_REJ => 'BŁĘDY',
        O_ACC => 'PRZYJĘTE',
        FIXED => 'POPRAWIONE',
        KONEC => 'ZAKOŃCZONE',
        KONEC => 'ZAKOŃCZONE',
        W4UZUP => 'UZUPEŁNIĆ',
        UZUPED => 'UZUPEŁNIONE',
        UZU_CHECK => 'SPRAWDZANIE',
        KREJ1 => 'DO POPRAWY',//'KREJ1',
        KREJ2 => 'DO POPRAWY',//'KREJ2',
        FIXED1 => 'POPRAWIONE',//'FIXED1',
        FIXED2 => 'POPRAWIONE',//'FIXED2',
        W4CARD => 'DO SPRAWDZENIA',//'W4CARD',
        OREJ => 'DO POPRAWY',//'OREJ',
        F_OK => 'PLIKI OK',//'F_OK',
        ORD_OK => 'PRZYJĘTE'//'ORD_OK'
    );
    
    public function status_zamow($stat) {
        if( $stat == null) return $this->order_stat[PRIV];
        else 
                if( array_key_exists($stat , $this->order_stat) )
                        return $this->order_stat[$stat];
                else
                        return $stat;
    }
    
    // Statusy kart
    public $statusOfCard = array(
        PRIV => 'PRYWATNA',//'PRIV',
        NOWKA => 'NOWA',//'NOWKA',
        W4D => 'DTP?',//'W4D',
        W4DP => 'DTP?/P?',//'W4DP',
        W4DPNO => 'DTP?/P-',//'W4DPNO',
        W4DPOK => 'DTP?/P+',
        W4PDNO => 'DTP-/P?',
        W4PDOK => 'DTP+/P?',
        DOK => 	'DTP+',
        DNO => 'DTP-',
        DOKPNO => 'DTP+/P-',
        DOKPOK => 'DTP+/P+',
        DNOPNO => 'DTP-/P-',
        DNOPOK	=> 'DTP-/P+',
        KONEC => 'ZAKOŃCZ.',

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
    
    public function statusOfCard( $stat ) {
        if( $stat != NULL) {
            return $this->statusOfCard[$stat];
        }
        return $stat;
    }
    

    // Dla CakePdf, coby dla stylów generowało absolute urls
    public function assetUrl($path, $options = array()) {
        if (!empty($this->request->params['ext']) && $this->request->params['ext'] === 'pdf') {
            $options['fullBase'] = true;
        }
        return parent::assetUrl($path, $options);
    }  
    
}
