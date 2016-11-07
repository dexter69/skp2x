<?php
/**
 * CakePHP TaskHelper - helper dla widoków związanych z modelem TASK
 * @author dexter
 */
class TaskHelper extends AppHelper {

    public $helpers = array('Html');
    
    //Rozszerzające znaki do oznaczenia różnych sytuacji z kartami
    private $rozszerzenie = array(
        'perso' => '<span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>&nbsp;',
        'niebyc' => '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;',
        'plik' => '<span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>&nbsp;' 
    );
    // przygotój różne wartości do interfejsu etykiet
    public function countDataForEtykFromCardData( $card ) {
        
        switch( $card['etykieta'] ) {
            case 'niebyc':
                $card['klasa'] = 'niebyc';
                $card['hclass'] = 'name text-muted';
                //klasy li (klikaczy
                $card['active'] = 'bg-szare';
                $card['normal'] = 'bg-szare';
                $card['linput'] = ' disabled';
                $card['start'] = $this->rozszerzenie['niebyc'];
                $card['nazwa'] = $card['start'] . $card['name'];
                break;
            case 'plik': //drukujemy z gotowego załączonego pliku
                $card['klasa'] = 'plik';
                $card['hclass'] = 'name';
                //klasy li (klikaczy
                $card['active'] = 'bg-szare';
                $card['normal'] = 'bg-szare';
                $card['linput'] = ' disabled'; 
                $card['start'] = $this->rozszerzenie['plik'];
                $card['nazwa'] = $card['start'] . $this->Html->link( // link do pliku
                    $card['name'],
                    array('controller' => 'uploads', 'action' => 'download', $card['isetyfile'] ) 
                );
                break;
            default:
                $card['klasa'] = 'normal';
                $card['hclass'] = 'name';
                //klasy li (klikaczy
                $card['active'] = 'bg-primary';
                $card['normal'] = 'bg-info';
                $card['linput'] = '';                
                if( $card['isperso']) { //oznaczamy kartę z perso
                    $card['start'] = $this->rozszerzenie['perso'];
                } else {
                    $card['start'] = '';
                }
                $card['nazwa'] = $card['start'] . $card['name'];
        }
        return $card;
    }

}
