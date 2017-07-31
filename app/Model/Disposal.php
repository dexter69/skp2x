<?php
App::uses('AppModel', 'Model');

class Disposal extends AppModel {
    
    public $useTable = 'orders';

    public $hasMany = array(        
        'Badge' => array(
            'fields' => array('Badge.id', 'Badge.name')
        )        
    );
    
    private $searchParams = [
        'fields' => ['Disposal.id', 'Disposal.nr', 'Disposal.data_publikacji', 'Disposal.stop_day']
        ,'limit' => 50
    ];

    public $otrzymane = [];

    /*
        Metoda do naszego srogiego szukania */
    public function theSearch() {

        if( !empty( $this->otrzymane ) ) {
            
            if( $this->datesAreSet() ) {
                $this->addDates();                
            } 
            $result = $this->find('all', $this->searchParams);
            return $result;
        }
        return ['kwa' => 'muu'];        
    }

    /* sprawdza, czy w otrzymanych parametrach są ustawione daty */
    private function datesAreSet() {
        return !!$this->otrzymane['od'] || !!$this->otrzymane['do'];        
    }

    private function addDates() {
    
        $od = $this->convertDate( $this->otrzymane['od']);
        $do = $this->convertDate( $this->otrzymane['do']);
        // 1. obie daty ustawione
        if( !!$this->otrzymane['od'] && !!$this->otrzymane['do'] ) { 
            $this->searchParams['conditions'] = [
                "AND" => [
                    'Disposal.stop_day >=' => $od,
                    'Disposal.stop_day <=' => $do
                ]
                
            ];
        } else { // znaczy, że tylko jedna z dat jest ustawiona
            if( !!$this->otrzymane['od'] ) { 
                $this->searchParams['conditions'] = [
                    'Disposal.stop_day >=' => $od
                ];
            } else {
                $this->searchParams['conditions'] = [
                    'Disposal.stop_day <=' => $do
                ];
            }
        }      

    }

    public function convertDate( $date = null ) {

        if( $date ) { 
            $arr = explode(".", $date);
            return $arr[2] . "-" . $arr[1] . "-" . $arr[0];
        }
        return "1901-01-31";
    }

}
