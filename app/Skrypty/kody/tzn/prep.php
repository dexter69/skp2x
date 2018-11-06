<?php
/* Rozdział kodów z pliku na pliki w .csv
$info zawiera nazwy plików do wygenerowania oraz wartości,
ile kazdy z plików ma zawierać kodów */

$inFile = "70k_2018.txt";

$info = [
    '13044_VIP19' => 150,
    '13045_VIP20' => 150,
    '13046_A19' => 2000,
    '13047_A20' => 2000,
    '13048_B19' => 2000,
    '13049_C19' => 7000,
    '13050_C20' => 7000,
    '13051_D19' => 8500,
    '13052_D20' => 8500,
    '13053_B20' => 2000,
    '13054_FIS19' => 1200,
    '13055_FIS20' => 1200,
    '13066_Kwalifikacje40' => 10000,
    '13080_Lotos19' => 387,
    '13081_Lotos20' => 387,
    '13082_TZN19' => 500,
    '13083_TZN20' => 500,
    '13084_T19' => 962,
    '13085_T20' => 962,
    '13086_Premium19' => 364,
    '13087_Premium20' => 364,
    '13088_PZN19' => 300,
    '13089_PZN20' => 300
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