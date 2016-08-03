<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
    public function print_r2($val){ echo '<pre>'; print_r($val); echo  '</pre>';}	
    
    // Dane do wysłania e-maila
    public $e_data = array();
    
    /* Przygotuj tablicę z odbiorcami e-maila
     * $eventtab - tablica z danymi dla mozdelu Event (z requestdata) */
    public function prepEmailData( $eventtab = array() ) {
        
        $this->tematTrescLink($eventtab);
        foreach( $this->e_data['value']['Event'] as $ewent ) {
                $uids[$ewent['user_id']] = 1; //przypisz na razie cokolwiek	
        }
        if( $eventtab['job_id'] ) { //zlecenie, trza też handlowcom wyslac
            foreach( $this->e_data['value']['Card'] as $karta ) {
                $uids[$karta['user_id']] = 1; } //przypisz na razie cokolwiek					
        }
        $uids[4] = 1; // Jola zawsze dostaje			
        unset($uids[$this->Auth->user('id')]); // generujący zdarzenie nie dostaje maila
        $uids[1] = 1; // Darek zawsze dostaje, nawet jak sam napisze                        
        $tab = array();
        foreach( $uids as $key => $wartosc) { $tab[] = $key; }
        $this->ludzikoza( $tab, $eventtab );
    }
    
    private function ludzikoza( $tab, $eventtab ) {
        
        $ludziki = $this->Event->User->find('all', array(
                'conditions' => array('User.id' => $tab),
                'recursive' => 0
        ));
        
        $odbiorcy = array();
        foreach( $ludziki as $ludz) {
            if( $ludz['User']['enotif'] != null ) {
                $odbiorcy[] = $ludz['User']['enotif']; }
        }
        if( $eventtab['co'] == p_ov ) { // w wypadku zakończenia perso, dodatkowo dostaje Krysia
            $odbiorcy[] = 'info@polskiekarty.pl';
        }
        // Frank nie chce tych powiadomień...
        if( $eventtab['co'] == p_ov || $eventtab['co'] == send_o ) {
            $klucz = array_search('grafik@polskiekarty.pl',  $odbiorcy);
            if( $klucz != false ) {
                unset( $odbiorcy[$klucz] );
            }
        }
        $this->e_data['odbiorcy'] = $odbiorcy;
    }
    
    /* Przygotuj temat, treść i link e-maila
     * * $eventtab - tablica z danymi dla mozdelu Event (z requestdata) */
    private function tematTrescLink( $eventtab = array() ) {
        
        if( $eventtab['order_id'] ) { // do handlowego
            $this->e_data['value'] = $this->Event->Order->find('first', array(
                    'conditions' => array('Order.id' => $eventtab['order_id'])));
            $this->e_data['temat'] = 'ZAM ' . $this->bnr2nrh2($value['Order']['nr'],$value['User']['inic'],false);
            $this->e_data['link'] = array('controller' => 'orders', 'action' => 'view', $eventtab['order_id']); }
        else { // do produkcyjnego
            $this->e_data['value'] = $this->Event->Job->find('first', array(
                'conditions' => array('Job.id' => $eventtab['job_id'])));
            $this->e_data['temat'] = 'ZLE ' .  $this->bnr2nrj2($value['Job']['nr'],$value['User']['inic'],false);
            $this->e_data['link'] = array('controller' => 'jobs', 'action' => 'view', $eventtab['job_id']); 
        }
        $this->e_data['temat'] .=   ', ' . $this->Auth->user('name'). ' ' .
                    $this->evtext2[$eventtab['co']][$this->Auth->user('k')];
        if($eventtab['card_id']) {
            if( $eventtab['co'] == put_kom ) { $this->e_data['temat'] .= ' odnośnie karty:'; }
            foreach( $value['Card'] as $karta ) {
                if( $karta['id'] == $eventtab['card_id'] ) { $this->e_data['temat'] .= ' ' . $karta['name']; }
            }
        } 
        $this->e_data['tresc'] = $eventtab['post'];
    }
    
}
