<?php
/* Rozdział kodów z pliku na pliki w .csv
$info zawiera nazwy plików do wygenerowania oraz wartości,
ile kazdy z plików ma zawierać kodów */

$inFile = "26k_2021.txt";

$info = [
    'A_15' => 430,
    'A_16' => 430,
    'B_15' => 430,
    'B_16' => 430,
    'C_15' => 2550,
    'C_16' => 2550,
    'D_15' => 3860,
    'D_16' => 3860,
    'FF_15' => 420,
    'FF_16' => 420,
    'PREMIUM_15' => 374,
    'PREMIUM_16' => 374,
    'PZN_15' => 270,
    'PZN_16' => 270,
    'TZN_15' => 320,
    'TZN_16' => 320,
    'VIP_15' => 110,
    'VIP_16' => 110,
    'T_15' => 992,    
    'T_16' => 992,
    'KWALIFIKACJE' => 5000,
    'LOTOS_15' => 503,
    'LOTOS_16' => 503
];

function printSet( $nameOfOutputFile = "xyz.txt", $ile=1, $fileHandler) {
    
    $out = "out\\$nameOfOutputFile.csv";
    $fo = fopen($out, "w");
    if($fo) {
        fwrite($fo, '"kod","nr"' . PHP_EOL);
        for( $i=1; $i<=$ile; $i++) {
            $kod = trim(fgets($fileHandler));
            $long = strlen($ile);
            $nr = substr("0000{$i}", -$long);
            $outstr = '"' . $kod . '","' . $nr . '"' . PHP_EOL;
            fwrite($fo, $outstr );
        }
        fclose($fo);
    } else {
        echo "\nWtf!";
    }
}

$h = fopen($inFile, "r");

if( $h ) {
    foreach( $info as $name => $ile ) {
        printSet( $name, $ile, $h );
    }
    fclose($h);
} else {
    echo "Cos nie teges!";
}