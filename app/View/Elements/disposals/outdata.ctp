<?php
    $start = $offset;
    $stop = $offset + $max -1; //standard
    if( $stop >= count($data) ) {
        $stop = count($data) - 1; // koniec danych, korygujemy
    }
    
    for( $i = $start; $i <= $stop; $i++ ) {
        echo $this->element('disposals/cell', ['piece' => $data[$i]]);
    }