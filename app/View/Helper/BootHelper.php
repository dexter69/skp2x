<?php
/**
 * Przydatne funkcje w częściach aplikacji używających Bootstrap layout
 *
 * @author dexter
 */

App::uses('AppHelper', 'View/Helper');

class BootHelper extends AppHelper {

    public $helpers = array('Html');

    /**
     *  $jshtml musi być prawidłowym kodem js, nazwa $jshtml bo możemy użyć wyniku plików .ctp
     *  Dodaje blok skryptu w dolnym bloku     */
    public function bottomScript($jshtml) {
        return $this->Html->scriptBlock(
            $this->stripScript($jshtml), // w AppHelper - na wselki wypadek, usuwa początkowy tag <script> jeżeli takowy istnieje
            ['block' => 'scriptBottom']
        );
    }

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

    // convert base nr to nrh - numer handlowego
	public function bnr2nrh( $bnr = null, $inic = null ) {
        
        $formed = "<strong>" . (int)substr((int)$bnr,2) . "</strong>" . '/' . substr((int)$bnr,0,2);
        //.' H';
        $formed .= $inic ? " $inic" : " H";
        return $formed;
    }
}