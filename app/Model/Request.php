<?php
// nazwa obiektu w którym bedą przetrzymywane wybrane dane do szukania
define('NEW_OBJ_NAME','request');
//defaultowa wartość wyboru dla pasków magnetycznych
define('MAG_DEFAULT', 'dsm'); // dsm - does not matter
//defaultowa wartość wyboru dla chipów
define('CHIP_DEFAULT', 'dsm');
//defaultowa wartość wyboru dla plastiku
define('PVC_DEFAULT', 'any');
//defaultowa wartość wyboru dla kształtu karty
define('SHA_DEFAULT', 'any');

/*  To ma być nowy model operujący na tablicy orders dla celów zrobienia lebszego listingu
 *  i wyszukiwania handlowych. Oraz obsługi etykiet.
 *  Po prostu chcemy czysty kod */

App::uses('AppModel', 'Model');

class Request extends AppModel {
    
    public $useTable = 'orders';

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
                        'display' => 'Stykowy', 
                        'title' => 'Karty z chipem stykowym.' 
                    ],
                    // opcja 4
                    [                         
                        'value' => 'any',                        
                        'display' => 'Dowolny', 
                        'title' => 'Karty z dowolnym chipem.' 
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
                        'display' => 'PVC - standardowe', 
                        'title' => 'Karty zrobione ze zwykłego PVC.' 
                    ],
                    // opcja 2
                    [                         
                        'value' => 'exo',                        
                        'display' => 'PVC - nietypowe', 
                        'title' => 'Karty zrobione z nietypowego PVC.' 
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
                        'title' => 'Karty o dowolnym kształcie.' // podpowiedź dla użytkownika
                    ],
                    // opcja 1
                    [                         
                        'value' => 'std',                        
                        'display' => 'Kształt - standardowy', 
                        'title' => 'Karty standard ISO.' 
                    ],
                    // opcja 2
                    [                         
                        'value' => 'exo',                        
                        'display' => 'Kształt - nietypowy', 
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

    /*
    Tu nasza metoda do szukania po cehach kart
    */
    public function theSpecialSerach( $opcje = [] ) {

        $wyniki = $this->find('first');
        //return $opcje;
        return $wyniki;
    }
    
    public $hasMany = array(
        'Ticket' => array(
            'fields' => array('Ticket.id', 'Ticket.name', 'Ticket.ilosc', 'Ticket.mnoznik')
        )
    );
    
    public $belongsTo = 'User';

    
    
}
