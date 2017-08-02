<?php

/* To ma być nowy model operujący na tablicy cardss dla celów Special Search.
 * Po prostu chcemy czysty kod */

App::uses('AppModel', 'Model');

class Badge extends AppModel {

    public $useTable = 'cards';    

    /*
        Metoda do wyszukiwania kart po ich parametrach */
    public function theSpecialSearch() {

        $opcje = [
            'fields' => ['Badge.id', 'Badge.name'],
            'limit' => 3,
            //'group' => ['Order.id']
        ];
        $a = $this->find('all', $opcje);

        return $a;
    }
    
    public $belongsTo = [        
        'Disposal'
    ];
}