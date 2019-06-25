<?php

define( "FOLDER", ".");

// Wczytaj kody z pliku o nazwie w $nazwa, zwróć w formie tablicy
function wczytaj( $nazwa ) {

    $h = fopen( "./" . FOLDER . "/" . $nazwa ,"r");
    if( $h ) {
        $out = [];
        while( $s = fgets($h)) {
            $out[] = trim($s);
        }
        fclose($h);
        return $out;
    }
    return ["GIBON"];
}

function zasysnij( $arrTab = [] ) {

    $ret = [];
    if( !empty($arrTab) ) {        
        foreach( $arrTab as $name ) {
            $ret = array_merge( $ret, wczytaj($name) );            
        }
    }
    return $ret;
}