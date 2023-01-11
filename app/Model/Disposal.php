<?php
App::uses('AppModel', 'Model');

class Disposal extends AppModel {
    
    public $useTable = 'orders'; 

    public $hasMany = array(        
        'Badge' => array(
            'fields' => array(
                'Badge.id', 'Badge.name', 'Badge.a_material', 'Badge.r_material',
                'Badge.ksztalt', 'Badge.chip', 'Badge.mag'
            )
        )        
    );   

    public $belongsTo = 'User';

    /*
        Tu zapisana cała struktura, która zawiera dane konfiguracyjne
        dla formularza do wyszukiwania zamówień po specyficznych cechach kart
    */    
    
    public $configForSpecialSearching = [
            // dane dla daty od
            'od' => [
                'id' => 'picker-od',
                'label' => 'OD:',               
                'acc' => NEW_OBJ_NAME . '.od' /* Tekstowa wartość ibiektu albo klucza,
                do którego skrypt ma zapisywać vartośc wybranej daty */                
            ],
            // dane dla daty do
            'do' => [
                'id' => 'picker-do',
                'label' => 'DO:',                
                'acc' => NEW_OBJ_NAME . '.do'                
            ],
            'mag' => [ // konfiguracja selecta pod pasek mag
                'id' => 'magsel', // id elementu html
                'acc' => NEW_OBJ_NAME . '.mag',                
                // opcje elementu select
                'opcje' => [
                    // opcja 0
                    [
                         // wartość wybranej opcji - ta wartość będzie przesyłana na serwer
                        'value' => MAG_DEFAULT,                        
                        'display' => 'Pasek magnetyczny?', // wartość wyświetlana w elemencie select
                        'title' => 'Karta z paskiem magnetycznym lub bez.' // podpowiedź dla użytkownika
                    ],
                    // opcja 1
                    [                         
                        'value' => 'hico',                        
                        'display' => 'HiCo', 
                        'title' => 'Karty z paskiem magnetycznym HiCo.' 
                    ],
                    // opcja 2
                    [                         
                        'value' => 'loco',                        
                        'display' => 'LoCo', 
                        'title' => 'Karty z paskiem magnetycznym LoCo.' 
                    ],
                    // opcja 3
                    [                         
                        'value' => 'any',                        
                        'display' => 'HiCo lub LoCo', 
                        'title' => 'Karty z dowolnym paskiem magnetycznym.' 
                    ],
                    // opcja 4
                    [                         
                        'value' => 'no',                        
                        'display' => 'BEZ paska mag.', 
                        'title' => 'Karty bez paska magnetycznego.' 
                    ],
                    'default' => 0 // która opcja jest domyślna
                ]
            ],
            'per' => [ // konfiguracja selecta pod personalizację
                'id' => 'persel', // id elementu html
                'acc' => NEW_OBJ_NAME . '.per',                
                // opcje elementu select
                'opcje' => [
                    // opcja 0
                    [
                         // wartość wybranej opcji - ta wartość będzie przesyłana na serwer
                        'value' => PER_DEFAULT,                        
                        'display' => 'Personalizacja?', // wartość wyświetlana w elemencie select
                        'title' => 'Karta z personazlizacją lub bez.' // podpowiedź dla użytkownika
                    ],
                    // opcja 1
                    [                         
                        'value' => 'term',                        
                        'display' => 'Termodruk', 
                        'title' => 'Personalizacja termodrukiem' 
                    ],
                    // opcja 2
                    [                         
                        'value' => 'embo',                        
                        'display' => 'Embossing', 
                        'title' => 'Personalizacja embossingiem' 
                    ],
                    // opcja 3
                    [                         
                        'value' => 'lami',                        
                        'display' => 'Pod laminatem', 
                        'title' => 'Personalizacja pod laminatem' 
                    ],
                    // opcja 4
                    [                         
                        'value' => 'any',                        
                        'display' => 'Jakakolwiek', 
                        'title' => 'Personalizacja dowolnego typu' 
                    ],
                    // opcja 5
                    [                         
                        'value' => 'no',                        
                        'display' => 'BEZ personalizacji', 
                        'title' => 'Karty bez personalizacji.' 
                    ],
                    'default' => 0 // która opcja jest domyślna
                ]
            ],
            'chip' => [
                'id' => 'ischip',
                'acc' => NEW_OBJ_NAME . '.chip',                
                // opcje elementu select
                'opcje' => [
                    // opcja 0
                    [
                         // wartość wybranej opcji - ta wartość będzie przesyłana na serwer
                        'value' => CHIP_DEFAULT,                        
                        'display' => 'Chip?', // wartość wyświetlana w elemencie select
                        'title' => 'Karta z chipem lub bez.' // podpowiedź dla użytkownika
                    ],
                    // opcja 1
                    [                         
                        'value' => 'M',                        
                        'display' => 'Mifare', 
                        'title' => 'Karty z chipem Mifare.' 
                    ],
                    // opcja 2
                    [                         
                        'value' => 'U',                        
                        'display' => 'Unique', 
                        'title' => 'Karty z chipem Unique.' 
                    ],
                    // opcja 3
                    [                         
                        'value' => 'S',                        
                        'display' => 'SLE', 
                        'title' => 'Karty z chipem stykowym.' 
                    ],
                    // opcja 4
                    [                         
                        'value' => 'any',                        
                        'display' => 'Dowolny', 
                        'title' => 'Karty z dowolnym chipem.' 
                    ],
                    // opcja 5
                    [                         
                        'value' => 'no',                        
                        'display' => "BEZ chip'a", 
                        'title' => "Karty bez chip'a" 
                    ],
                    'default' => 0 // która opcja jest domyślna
                ]
            ],
            'pvc' => [
                'id' => 'whatpvc',
                'acc' => NEW_OBJ_NAME . '.pvc',
                // opcje elementu select
                'opcje' => [
                    // opcja 0
                    [
                         // wartość wybranej opcji - ta wartość będzie przesyłana na serwer
                        'value' => PVC_DEFAULT,                        
                        'display' => 'Dowolne PVC', // wartość wyświetlana w elemencie select
                        'title' => 'Karty z jakiegokolwiek materiału.' // podpowiedź dla użytkownika
                    ],
                    // opcja 1
                    [                         
                        'value' => 'std',                        
                        'display' => 'Standard PVC', 
                        'title' => 'Karty zrobione ze zwykłego PVC.' 
                    ],
                    // opcja 2
                    [                         
                        'value' => 'bio',                        
                        'display' => 'Bio PVC', 
                        'title' => 'Karty zrobione z BIO PVC.' 
                    ],
                    // opcja 3
                    [                         
                        'value' => 'tra',                        
                        'display' => 'Transparent PVC', 
                        'title' => 'Karty zrobione z przeźroczystego PVC.' 
                    ],
                    // opcja 4
                    [                         
                        'value' => 'clr',                        
                        'display' => 'Kolorowe PVC', 
                        'title' => 'Karty zrobione z barwionego PVC.' 
                    ],
                    // opcja 5
                    [                         
                        'value' => 'foil',                        
                        'display' => 'PVC z folią', 
                        'title' => 'Karty zrobione z PVC z folią' 
                    ],
                    // opcja 6
                    [                         
                        'value' => 'exo',                        
                        'display' => 'inne PVC', 
                        'title' => 'Karty zrobione z nietypowego PVC' 
                    ],
                    'default' => 0 // która opcja jest domyślna
                ]
            ],
            'sha' => [
                'id' => 'shape',
                'acc' => NEW_OBJ_NAME . '.sha',
                // opcje elementu select
                'opcje' => [
                    // opcja 0
                    [
                         // wartość wybranej opcji - ta wartość będzie przesyłana na serwer
                        'value' => SHA_DEFAULT,                        
                        'display' => 'Kształt dowolny', // wartość wyświetlana w elemencie select
                        'title' => 'Karty o dowolnym kształcie, czyli wszystkie karty' // podpowiedź dla użytkownika
                    ],
                    // opcja 1
                    [                         
                        'value' => 'std',                        
                        'display' => 'Kształt - standardowy', 
                        'title' => 'Karty standard ISO.' 
                    ],
                    // opcja 2
                    [                         
                        'value' => '2+1',                        
                        'display' => '2+1', 
                        'title' => 'Kształt "2+1" - karta z dwoma odłamywalnymi częściami.' 
                    ],
                    // opcja 3
                    [                         
                        'value' => 'bx3',                        
                        'display' => 'Brelok x 3', 
                        'title' => 'Trzy małe, odłamywalne części' 
                    ],
                    // opcja 4
                    [                         
                        'value' => 'exo',                        
                        'display' => 'Kształt NIETYPOWY', 
                        'title' => 'Karty o nietypowym kształcie/rozmiarach.' 
                    ],                    
                    'default' => 0 // która opcja jest domyślna
                ]
            ],            
            'varname' => NEW_OBJ_NAME,
            /*  struktura tworzonego obiektu w którym będą przechowywane dane odnośnie
                parametrów poszukiwań */
            'theobj' => [ 
                'od' => null, // Data od
                'do' => null,  // data do
                'mag' => null, // Rdzaj paska magnetycznego                    
                'chip' => null, // czy jest chip
                'pvc' => null, // jakie pvc
                'sha' => null // kształt karty
            ]
    ];    

    // jak szukane wartości mapują się na wartości w DB
    private $mapSearchOptionsToDbOptions = [
        'pvc' => [
            PVC_DEFAULT => 99, // tak bez znaczenia na prawdę, w bazie nie ma takiej wartości
            'std' => 1,
            'bio' => 2,
            'tra' => 3,
            'clr' => 4,
            'foil' => 5,
            'exo' => 0
        ],
        'sha' => [
            SHA_DEFAULT => 99,
            'std' => 0,
            '2+1' => 2,
            'bx3' => 3,
            'exo' => 1
        ],
        'chip' => [
            CHIP_DEFAULT => 99,
            'M' => 3,
            'U' => 2,
            'S' => 4,
            'no' => 0
        ]
        ,
        'mag' => [
            MAG_DEFAULT => 99,
            'hico' => 1,
            'loco' => 2,
            'no' => 0
        ]
    ];

    public $searchParams = [
        'fields' => [
            'Disposal.id', 'Disposal.nr', 'Disposal.user_id',
            'Disposal.data_publikacji', 'Disposal.stop_day',
            'User.id', 'User.inic'
        ]
        ,'order' => 'Disposal.nr'
        ,'limit' => 1000
        //To potrzebne, by mozna warunki dla obu modeli zapodawać        
        ,'joins' => [
            [
                'table' => 'cards',
                'alias' => 'Badge',
                'type' => 'Left',
                'conditions' => ['Disposal.id = Badge.order_id']
            ]
        ]               
        ,'conditions' => []
    ];

    public function setTheSearchParams( $otrzymane = [] ) {

        $this->otrzymane = $otrzymane;
        if( !empty( $this->otrzymane ) ) {            
            $this->addDates(); // dodaj zakres date, jeżeli jest ustawiony
            $this->addMaterial(); // dodaj materiał karty, jeżeli jest ustawiony
            $this->addShape(); // dodaj szukanie po kształcie karty, jeżeli jest ustawione
            $this->addChip(); // dodaj szukanie po chip'ie, jeżeli jest ustawione
            $this->addMag(); // dodaj szukanie po pasku mag., jeżeli jest ustawione
        }
        return $this->searchParams;
    }

    private $otrzymane = [];

    // to ponizej, do doopy
    public function theSpecialFindIle() {

        $options = $this->searchParams;
        unset($options['limit']);
        return $this->find('count', $options);
    }

    public function theSpecialFind() {

        $getit = $this->find('all', $this->searchParams);

        return $this->oczysc( $getit);
    }

    /*
     *  Usuń duplikaty
     */
    private function oczysc( $dataToClean = [] ) {
        
        $nr = 1400000; $result = [];        
        foreach( $dataToClean as $key => $row ) {
            if( $row['Disposal']['nr'] != $nr ) { // nowe, przepisujemy i zapamietujemy id
                $result[] = $row;
                $nr = $row['Disposal']['nr'];
            } 
        }
        return $result;
    }

    private function addMag() {

        if( $this->otrzymane['mag'] != MAG_DEFAULT ) { // jakiś wybór odnośnie pasków mag ustawiony
            if( $this->otrzymane['mag'] != 'any' ) { // mamy konkretny pasek mag
                $this->searchParams['conditions']['Badge.mag'] =
                    $this->mapSearchOptionsToDbOptions['mag'][$this->otrzymane['mag']];
            } else { // dowolny pasek mag.
                $this->searchParams['conditions']['Badge.mag >'] = 0;
            }
        }

    }

    private function addChip() {

        if( $this->otrzymane['chip'] != CHIP_DEFAULT ) { // jakiś wybór odnośnie chip'ów ustawiony
            if( $this->otrzymane['chip'] != 'any' ) { // mamy konkretny chip
                $this->searchParams['conditions']['Badge.chip'] =
                    $this->mapSearchOptionsToDbOptions['chip'][$this->otrzymane['chip']]; 
            } else { // dowolny chip
                $this->searchParams['conditions']['Badge.chip >'] = 0;
            }
        }
    }    

    private function addShape() {

        if( $this->otrzymane['sha'] != SHA_DEFAULT ) { // jakiś konkretny kształt wybrano 
            $this->searchParams['conditions']['Badge.ksztalt'] =
                $this->mapSearchOptionsToDbOptions['sha'][$this->otrzymane['sha']]; 
        }
    }

    private function addMaterial() {

        if( $this->otrzymane['pvc'] != PVC_DEFAULT ) { // jakiś konkretny materiał wybrany                        
            $val = $this->mapSearchOptionsToDbOptions['pvc'][$this->otrzymane['pvc']];
            $this->searchParams['conditions']['OR'] = [
                'Badge.a_material' => $val,
                'Badge.r_material' => $val
            ];

        }
    }

    private function addDates() {
    
        if( !!$this->otrzymane['od'] || !!$this->otrzymane['do'] ) { // jeżeli któraś z dat jest ustawiona
            $od = $this->convertDate( $this->otrzymane['od']);
            $do = $this->convertDate( $this->otrzymane['do']);
            // 1. obie daty ustawione
            if( !!$this->otrzymane['od'] && !!$this->otrzymane['do'] ) {                 
                $this->searchParams['conditions']['Disposal.stop_day >='] = $od;                      
                $this->searchParams['conditions']['Disposal.stop_day <='] = $do;
            } else { // znaczy, że tylko jedna z dat jest ustawiona
                if( !!$this->otrzymane['od'] ) {                      
                    $this->searchParams['conditions']['Disposal.stop_day >='] = $od;
                } else {
                    $this->searchParams['conditions']['Disposal.stop_day <='] = $do;     
                }
            }  
        }

    }

    private function convertDate( $date = null ) {

        if( $date ) { 
            $arr = explode(".", $date);
            return $arr[2] . "-" . $arr[1] . "-" . $arr[0];
        }
        return "1901-01-31";
    }

}
