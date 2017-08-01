<?php
App::uses('AppModel', 'Model');

class Disposal extends AppModel {
    
    public $useTable = 'orders';
    //public $actsAs = array('Containable');

    public $hasMany = array(        
        'Badge' => array(
            'fields' => array('Badge.id', 'Badge.name', 'Badge.a_material', 'Badge.r_material')
        )        
    );

    // jak szukane wartości mapują się na wartości w DB
    private $mapSearchOptionsToDbOptions = [
        'pvc' => [
            PVC_DEFAULT => 99, // tak na wypadek, nie ma w bazie 99, bo dla tej wartości materiał nieistotny
            'std' => 1,
            'bio' => 2,
            'tra' => 3,
            'clr' => 4,
            'foil' => 5,
            'exo' => 0
        ]
    ];
    
    private $searchParams = [
        'fields' => ['Disposal.id', 'Disposal.nr', 'Disposal.data_publikacji', 'Disposal.stop_day']
        ,'limit' => 50
        //To potrebne, by mozna warunki dla obu modeli zapodawać
        ,'joins' => [
            [
                'table' => 'cards',
                'alias' => 'Badge',
                'type' => 'Left',
                'conditions' => ['Disposal.id = Badge.order_id']
            ]
        ]
        //,'contain' => array('Badge')
        ,'conditions' => [
            /*
            'Disposal.stop_day >=' => '2017-06-15',
            'Disposal.stop_day <=' => '2017-07-31'
            ,'Badge.a_material' => 3
            */
            
        ]
    ];

    /*
        Metoda do naszego srogiego szukania */
    public function theSearch() {

        if( !empty( $this->otrzymane ) ) {            
            $this->addDates(); // dodaj zakres date, jeżeli jest ustawiony
            $this->addMaterial(); // dodaj materiał karty, jeżeli jest ustawiony
            $result = $this->find('all', $this->searchParams);
            return $result;
        }
        return ['kwa' => 'muu'];        
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

    // dodaj parametry wyszukiwania do tablicy "AND" klucza 'conditions'
    private function add2ANDx( $key, $val) {
        if( !array_key_exists('conditions', $this->searchParams) ||
            !array_key_exists('AND', $this->searchParams['conditions']) ) { /* klucze 'conditions' i/lub 'AND'  nie istnieją */
                // to utwórz je
                $this->searchParams['conditions'] = ['AND' => []];
        }
        
        $this->searchParams['conditions'][$key] = $val;
    }

    // dodaj parametry wyszukiwania do tablicy "AND" klucza 'conditions'
    private function add2AND( $key, $val) {
        $this->searchParams['conditions'][$key] = $val;
    }

    private function convertDate( $date = null ) {

        if( $date ) { 
            $arr = explode(".", $date);
            return $arr[2] . "-" . $arr[1] . "-" . $arr[0];
        }
        return "1901-01-31";
    }

}
