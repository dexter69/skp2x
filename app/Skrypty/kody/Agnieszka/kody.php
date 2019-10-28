<?php
/*
Klient Agnieszki:
http://skp.lan/customers/view/242
Raz na jakiś czas życzy sobie wygenrowanie kodów o następujących parametrach:
LLLLCC
gdzie L - duża litera, C - cyfra,
np. OEYL54
Generowane kody muszą być unikalne globalnie, czyli rózne od jakichkolwiek do tej pory wygenerowanych.
Czyli różne od kodów poprzednich bazach i w bazie bieżącej

Dobre narzędzie:
https://www.browserling.com/tools/text-from-regex

użyty regex: [A-Z]{4}\d\d
*/

require 'funkcje.php';

// To są stare bazy, wszystkie bazy - klienta i te, które robiliśmy my
$arrOfFiles = [
    'oldest.txt', // klienta
    'kody40k.txt',
    'kody30k.txt',
    'kody30k_cze-2018.txt', // baza wygenerowana 6.06.2018
    'kody30k_lis-2018.txt', // jak sama nazwa wskazuje
    'kody30k_lut-2019.txt',  // robione - 7.02.2019
    'kody30k_paz-2019.txt' // ostatnie robione 28.10.2019
];

// Plik z wygenerowanymi kodami, sprawdzamy czy się nie powtarzają z tym co już mamy
$newF = 'new.txt';

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