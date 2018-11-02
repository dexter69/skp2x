<?php

App::uses('AppHelper', 'View/Helper');

class WebixHelper extends AppHelper {

    public $helpers = ['Html'];

    public function css( $in = [] ) {

        if( DS == WIN) { // wersja DEV
            $suffix = ".css?v=" . time();
        } else { // wersja PROD
            $suffix = ".css?v=" . appVersion;
        }
        foreach( $in as $string ) {    
            $arr[] = $string . $suffix;
        }
        return $this->Html->css($arr);
    }

    /*  Na potrzeby webixa generuje nam odpowiednio sformatowane
        np. wersję aplikacji, rozróżnia wersje DEV i PROD */

    public function script( $devArr, $proArr ) {

        $arr = [];        
        if( DS == WIN) { // wersja DEV
            $in = $devArr;
            $suffix = ".js?v=" . time();
        } else { // wersja PROD
            $in = $proArr;
            $suffix = ".js?v=" . appVersion;
        }
        foreach( $in as $string ) {    
            $arr[] = $string . $suffix;
        }
        return $this->Html->script($arr);
    }

}