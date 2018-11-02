<?php

App::uses('AppHelper', 'View/Helper');

class WebixHelper extends AppHelper {

    public $helpers = ['Html'];

    public function css( $in = [] ) {

        foreach( $in as $string ) {    
            $arr[] = $string . ".css?v=" . appVersion;
        }
        return $this->Html->css($arr);
    }

    /*  Na potrzeby webixa generuje nam odpowiednio sformatowane
        np. wersję aplikacji, rozróżnia wersje DEV i PROD */

    public function script( $devArr, $proArr ) {

        $in = $out = [];
        if( DS == WIN) { // wersja DEV
            $in = $devArr;
        } else { // wersja PROD
            $in = $proArr;
        }
        foreach( $in as $string ) {    
            $arr[] = $string . ".js?v=" . appVersion;
        }
        return $this->Html->script($arr);
    }

}