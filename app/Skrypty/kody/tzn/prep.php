<?php
/* Rozdział kodów z pliku na pliki w .csv
$info zawiera nazwy plików do wygenerowania oraz wartości,
ile kazdy z plików ma zawierać kodów */

$inFile = "40k_2019-lato.txt";

$info = [
    '15441_FIS17' => 1000,
    '15442_FIS18' => 1000,
    '15443_A17' => 1400,
    '15444_A18' => 1400,
    '15445_B17' => 1400,
    '15446_B18' => 1400,
    '15447_C17' => 5000,
    '15448_C18' => 5000,
    '15449_D17' => 6000,
    '15450_D18' => 6000,
    '15451_Premium17' => 300,
    '15452_Premium18' => 300,
    '15453_TZN17' => 500,
    '15454_TZN18' => 500,
    '15455_Kwalifikacje' => 6500,
    '15456_KwalifikacjeZlote' => 500,
    '15457_VIP17' => 150,    
    '15458_VIP18' => 150
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