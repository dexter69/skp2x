<?php
/**
 * Przydatne funkcje w częściach aplikacji używających Bootstrap layout
 *
 * @author dexter
 */

App::uses('AppHelper', 'View/Helper');

class BootHelper extends AppHelper {

    /* funkcja do sprawdzania pewnych danych dla elementu select bootstrap
        $this->element('bootstrap/selects/select')
    */
    public function selectCtpCheck( $config = []) {

        $opcje = [                
            'els' => $config['options'],
            'default' => $config['default']
        ];        
        
        $error = [
            'els' => ['err', 'err1'],
            'default' => 0
        ];
                
        return $this->checkOptions($opcje, $error);
    }

    private function checkOptions( $options = [], $err = []) {

        if( empty($options) ) {
            return $err;
        }        
        if( !array_key_exists('els', $options) ) {
            return $err;
        }
        if( !array_key_exists('default', $options) ) {
            return $err;
        }
        if( !array_key_exists($options['default'], $options['els']) ) {
            return $err;
        }
        if( count($options['els']) < 2 ) {
           return $err;
        }        
        return $options;
    }
}