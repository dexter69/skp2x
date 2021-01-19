<?php
/* Rozdział kodów z pliku na pliki w .csv
$info zawiera nazwy plików do wygenerowania oraz wartości,
ile kazdy z plików ma zawierać kodów */

$inFile = "25k_2020.txt";

$info = [
    'A_16' => 550,
    'A_17' => 550,
    'B_16' => 550,
    'B_17' => 550,
    'C_16' => 1900,
    'C_17' => 1900,
    'D_16' => 2300,
    'D_17' => 2300,
    'PREMIUM_16' => 210,
    'PREMIUM_17' => 210,
    'PZN_16' => 180,
    'PZN_17' => 180,
    'TZN_16' => 230,
    'TZN_17' => 230,
    'VIP_16' => 65,
    'VIP_17' => 65,
    'T_16' => 530,    
    'T_17' => 530,
    'KWALIFIKACJE' => 5100
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