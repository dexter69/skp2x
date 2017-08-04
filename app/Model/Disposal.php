<?php
App::uses('AppModel', 'Model');

class Disposal extends AppModel {
    
    public $useTable = 'orders';    

    public $hasMany = array(        
        'Badge' => array(
            'fields' => array(
                'Badge.id', 'Badge.name', 'Badge.a_material', 'Badge.r_material',
                'Badge.ksztalt', 'Badge.chip'
            )
        )        
    );

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
    ];

    private $searchParams = [
        'fields' => ['Disposal.id', 'Disposal.nr', 'Disposal.data_publikacji', 'Disposal.stop_day']
        ,'limit' => 50
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

    /*
        Metoda do naszego srogiego szukania */
    public function theSearch() {

        if( !empty( $this->otrzymane ) ) {            
            $this->addDates(); // dodaj zakres date, jeżeli jest ustawiony
            $this->addMaterial(); // dodaj materiał karty, jeżeli jest ustawiony
            $this->addShape(); // dodaj szukanie po kształcie karty, jeżeli jest ustawione
            $this->addChip(); // dodaj szukanie po chip'ie, jeżeli jest ustawione
            $result = $this->find('all', $this->searchParams);
            array_unshift($result, $this->searchParams['conditions']);
            return $result;
        }
        return ['kwa' => 'muu'];        
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
