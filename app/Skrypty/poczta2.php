<?php

/* Lepsza wersja skryptu
*/
$time_start = microtime(true); // mierzymy czas wykonania skryptu

// Potrzebne stałe
define("READ", "SELECT * FROM events WHERE sent=0");    // nie wysłane zdarzenia
define("UQUERY", "UPDATE events SET sent=1 WHERE id="); // sql do uaktualnienia

// startowy string - gdy "nothing to do"
define("START_STR", ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>   "); 
// startowy string - gdy coś jest
define("START_STR2", "#########################################   "); 

require_once '../Config/database.php';
require_once '../Config/email.php'; // dane do serwera smtp
require_once 'class.phpmailer.php';
require_once 'class.smtp.php';
require_once 'class.poczta2.php';

/*  przy tworzeniu nowego obiektu łączymy się z bazą i wczytujemy rekord jeżeli takowy
    istnieje */ 
$poczta = new POCZTA(READ);

// jeżeli coś mamy, to wyślij e-mail
$poczta->sendMail();

// Posprzątaj na końcu
$poczta->clean();

if( $poczta->homePlTime != null ) { // czas interakcji z serwerem pocztowym
    print("\nCzas Home.pl: $poczta->homePlTime ms");
}
//logujemy czas wykonania skryptu
$script_time = (microtime(true) - $time_start) * 1000; // koniec pomiaru, chcemy w milisekundach
print("\nCzas wykonania całego skryptu: $script_time ms\n");

