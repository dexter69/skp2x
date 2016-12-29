<?php

/* 
 * Prosty skrypt produkujący bazę zakresów. Bierze plik tekstowy, każdą linię traktuje jako osobną wartość.
    Dla batona 500 szt. wyłuskuje 1, 500, 501, 1000, 1001, 1500 itd i tworzy pary z nich */

$inbat = 350; // ile kart w batonie
$fname = $argv[1];

$handle = fopen($fname, "r");
$i = 0;
if( $handle ) {
    echo "l;p\n";
    while (($stri = fgets($handle)) !== false) { // dopuki coś mamy        
        $str = '"' . trim($stri) . '"'; // chcemy bez znaku nowej linii (trim)     
        $i++;
        if( ($i % $inbat) < 2 ) {
            if( ($i % $inbat) == 1 ) {
                echo $str . ";";
            } else {
                echo $str . "\n";
            }
        }
    }
    //echo "suma = $i\n\n";
    fclose($handle);
} else {
    print("\nKant open fajl $fname");
}
