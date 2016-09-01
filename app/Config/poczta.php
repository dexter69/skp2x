<?php

/* 
 * Skrypt wysyłyjący maile z crona (zamiast z wywoływanego przez użytkownika)
 */
$time_start = microtime(true); // mierzymy czas wykonania skryptu
// folder na server, gdzie przechowywany jest config bazy
define('SERVER_CONF_FOLDER', '/var/www/skp/skp.lan/public_html/app/Config/');
//print_r($argv);
require_once 'database.php';

// Dane dostępu do bazy
$dbconfig = new DATABASE_CONFIG;
$db = $dbconfig->default;
if( $db['ver'] == 'dev' ) { //We are on devel machine
    print("\nDevel");
} else {
    print("\nWe are on Linux, path would be: \n" . SERVER_CONF_FOLDER . 'database.php');
}
//nasze zapytanie - szukamy rekordów z sent == 0,
//czyli zdarzenia dla których e-mail nie został wysłany
$read = "SELECT * FROM events WHERE sent=0";
print("\n>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>   " . date("Y-m-d, H:i:s"));
// Zerżnięte z http://www.w3schools.com/php/php_mysql_connect.asp
try {
        $conn = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['database'], $db['login'], $db['password']);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // odczytaj wszystkie rekordy, które nie były wysłane
        $stmt = $conn->prepare($read);
        $stmt->execute();
        
        //pierwszy ze znalezionych
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        if( !empty($record) ) { // jeżeli coś jest
            /*
                1. wyślij e-maila
             *  2. oznacz rekord, że wysłany
             *  3. loguj wykonanie
             *  
            */
            //1
            print("\nNastepujacy rekord bylby wyslany via e-mail:\n");
            print_r($record);
            print("\n");
            
            //2
            // sql do oznaczenia, że e-mail z tym zdarzeniem został wysłany
            $update = "UPDATE events SET sent=1 WHERE id=" . $record['id'];
            // Wykonaj
            $stmt = $conn->prepare($update);            
            $stmt->execute();
            
            //3
            if( $stmt->rowCount() ) {
                print("Zapisano w bazie pomyslnie\n");
            } else {
                print("Nie udalo sie zapisac w bazie\n");
            }
        } else {
            print("\nNothing to do....");
        }
    }
catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
$conn = null;
$time = microtime(true) - $time_start; // koniec pomiaru
print("\nCzas wykonania skryptu: $time s\n\n");