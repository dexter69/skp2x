<?php
/*  Skrypt wysyłyjący maile z crona (zamiast z wywoływanego przez użytkownika)
 */

// Potrzebne stałe
define("READ", "SELECT * FROM events WHERE sent=0");    // nie wysłane zdarzenia
define("START_STR", "\n>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>   "); // startowy string
define("UQUERY", "UPDATE events SET sent=1 WHERE id="); // sql do uaktualnienia

$time_start = microtime(true); // mierzymy czas wykonania skryptu
// folder na server, gdzie przechowywany jest config bazy
//define('SERVER_CONF_FOLDER', '/var/www/skp/skp.lan/public_html/app/Config/');
//print_r($argv);

require_once '../Config/database.php';
require_once '../Config/email.php'; // dane do serwera smtp
require_once 'class.phpmailer.php';
require_once 'class.smtp.php';
require_once 'class.poczta.php';

// Dane dostępu do bazy
$dbconfig = new DATABASE_CONFIG;
$db = $dbconfig->default;

$czas = date("Y-m-d, H:i:s"); // teraz



// Zerżnięte z http://www.w3schools.com/php/php_mysql_connect.asp
try {
        //Próbujemy połączyć się z bazą
        $pdostr = "mysql:host=" . $db['host'] . ";dbname=" . $db['database'] . ";charset=UTF8";
        $conn = new PDO($pdostr, $db['login'], $db['password']);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // odczytaj wszystkie rekordy, które nie były wysłane
        $stmt = $conn->prepare(READ);
        $stmt->execute();
        
        //pierwszy ze znalezionych
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        // początkowy wiersz logowania
        print(START_STR . $czas . "\n");
        if( !empty($record) ) { // jeżeli coś jest
            //1 - wyślij e-maila
            
            $mail = new PHPMailer;
            // ustaw parametry maila
            $poczta = new POCZTA;
            $emailconf = new EmailConfig;
            // sprawdzamy parzystość id - by wysyłac naprzemiennie z różnych kont e-mail 
            if( $record['id'] % 2 == 0 ) { //parzyste
                $poczta->setMainEmailParams($mail, $emailconf->homepl_smtp);
            }
            else { // nieparzyste
                $poczta->setMainEmailParams($mail, $emailconf->homepl_smtp1);
            }
            $poczta->setRecsSubjectBody($mail, $record);
            
            if(!$mail->send()) {
                print("\nE-mail NIE został wysłany.\n\n");
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                print("\n\n");                
            } else {
                print("\nE-mail OK");
                //2 oznacz w bazie rekord, że wysłany
                // sql do oznaczenia, że e-mail z tym zdarzeniem został wysłany            
                $stmt = $conn->prepare(UQUERY . $record['id']);            
                $stmt->execute();
                //3 loguj wykonanie
                if( $stmt->rowCount() ) { 
                    print("\nZapisano w bazie pomyślnie");
                } else {
                    print("\nNie udało się zapisać w bazie");
                }
            }
        } else {
            print("\nNothing to do....");
        }
} catch(PDOException $e) {
        echo "DB connection failed: " . $e->getMessage();
}
$conn = null;
$time = (microtime(true) - $time_start) * 1000; // koniec pomiaru, chcemy w milisekundach
print("\nCzas wykonania skryptu: $time ms\n");