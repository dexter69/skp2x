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
        // początkowy wiersz
        print(START_STR . $czas);
        if( !empty($record) ) { // jeżeli coś jest
            /*
                1. wyślij e-maila
             *  2. oznacz rekord, że wysłany
             *  3. loguj wykonanie
            */
            
            //1
            $emailconf = new EmailConfig;
            //$emailconf->homepl_smtp
            
            $mail = new PHPMailer;
            $mail->isSMTP(); 
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'polskiekarty.pl';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'skp@polskiekarty.pl';                 // SMTP username
            $mail->Password = 'P9GsF@87&HoG';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            
            $mail->setFrom('skp@polskiekarty.pl', 'SKP');
            $mail->addAddress('darek@polskiekarty.pl', 'DG');     // Add a recipient
            
            $mail->isHTML(true);                                  // Set email format to HTML
            
            $mail->Subject = 'Skwakał ifona żźćńółśęą';
            $mail->Body    = 'Przyjdz dziś wieczorem <b>in bold!</b>';
            
            if(!$mail->send()) {
                print("\nMessage could not be sent.\n\n");
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                print("\nMessage has been sent");
            }
            
            //print("\nNastepujący rekord byłby wysłany via e-mail:\n");
            //print_r($record);
            //print("\n");
            
            //2
            // sql do oznaczenia, że e-mail z tym zdarzeniem został wysłany            
            $stmt = $conn->prepare(UQUERY . $record['id']);            
            $stmt->execute();
            
            //3
            if( $stmt->rowCount() ) {
                print("Zapisano w bazie pomyślnie\n");
            } else {
                print("Nie udało się zapisać w bazie\n");
            }
        } else {
            print("\nNothing to do....");
        }
} catch(PDOException $e) {
        echo "DB connection failed: " . $e->getMessage();
}
$conn = null;
$time = (microtime(true) - $time_start) * 1000; // koniec pomiaru, chcemy w milisekundach
print("\nCzas wykonania skryptu: $time ms\n\n");