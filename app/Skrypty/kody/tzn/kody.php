<?php
/*
2019-06-25
Na bazie skryptu dla klienta Agnieszki

Sprawdzamy unikalność bieżących i względem starszych koddów.

*/

require 'funkcje.php';

// To są starsze bazy
$arrOfFiles = [
    '70k_2018.txt',
];

// Plik z wygenerowanymi kodami, sprawdzamy czy się nie powtarzają z tym co już mamy
$newF = '40k_2019-lato.txt';

// Plik w którym zapisujemy wynik
$outF = 'res.txt';

/*
- Tworzymy tablicę $old, do której wczytujemy wszystkie stare kody, z nią będziemy sprawdzać nowe
- Nowe kody wczytujemy do tablicy $new
- Tworzymy tablicę $out, do której będzemy wpisywać nowe, sprwdzone kody
- Algorytm
Weź kod z $new, sprawdź czy nie ma go w $old i $out. Jezeli nie, to dodaj do $out
Zrób tak dla wszystkich
*/



$old = zasysnij($arrOfFiles);
$new = zasysnij([$newF]);

$out = []; $i = 0; $j = 0;

foreach($new as $kod) {
    if( !in_array($kod, $out) ) { // nie ma go w out
        if( !in_array($kod, $old) ) { // w starych też go nie ma
            $out[] = $kod; // bieżemy
            $i++;
            if( $i == 1000 ) { // To dla wizualizacji postępu
                $i = 0;
                echo "\n" . ++$j;
            }
        }
    }
}

//Zapisz wynik
$h = fopen($outF, "w");
foreach( $out as $kod ) {
    fwrite($h, $kod . "\n");
}
fclose($h);