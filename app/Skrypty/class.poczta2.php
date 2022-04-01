<?php
/* dodajemy rzeczy związane z bazą danych, chcemy, by przy tworzeniu instancji
     * skrypt sprawdzał połączenie z bazą i wczytywał rekord danych, jeżeli jest takowy
     */
class POCZTA {
    
    public $conection = null;
    
    public $rekord = null; // tu wczytujemy rekord z bazy

    public $konto = null; // informacja z którego konta zstało wysłane
    
    private $emailSent = false; // rezuktat wysyłania emaila
    private $emailErr = null;   // tu będziemy wpisywać błąd PHPMailera
    
    public $homePlTime = null; // chcemy czas interakcji z serwerem pocztowym Home.pl
    
    function __construct( $sql_read ) {
       
        $dbconfig = new DATABASE_CONFIG;
        $db = $dbconfig->default;
        
        // try to connect to db
        try {
            $pdostr = "mysql:host=" . $db['host'] . ";dbname=" . $db['database'] . ";charset=UTF8";
            $this->conection = new PDO($pdostr, $db['login'], $db['password']);
            // set the PDO error mode to exception
            $this->conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // odczytaj wszystkie rekordy, które nie były wysłane
            $stmt = $this->conection->prepare($sql_read);
            $stmt->execute();
        
            //pierwszy ze znalezionych
            $this->rekord = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "DB connection failed: " . $e->getMessage();
        }
    }
    
    // wyślij powiadomienie e-mailem
    public function sendMail()   {
        
        if( $this->rekord ) { // coś wczytaliśmy, więc wyślemy powiadomienie
            //startowy log - gdy coś jest
            print("\n" . START_STR2 . date("Y-m-d, H:i:s"));
            $emailconf = new EmailConfig;
            /* wysyłamy parzyste rekordy z innego konta niz nieparzyste (bo Home.pl nie lubi jak sie za dużo maili wysyła)
            Przenieśliśmy poniżej do if
            $config = ( $this->rekord['id'] % 2 == 0 ) ? $emailconf->homepl_smtp : $emailconf->homepl_smtp1;
            */
            if( $this->rekord['id'] % 2 == 0 ) {
                $emailconf->homepl_smtp;
                $this->konto = 'SMTP';
            } else {
                $emailconf->homepl_smtp1;
                $this->konto = 'SMTP-1';
            }
            
            $mail = new PHPMailer;
            //ustaw parametry
            $this->setMainEmailParams($mail, $config);
            // i pozostałe - treść
            $this->setRecsSubjectBody($mail);
            
            $this->homePlTime =  microtime(true); // chcemy zmierzyć czas gęgania do Home.pl
            // W $this->emailSent będzie info czy wysłaliśmy czy nie
            $this->emailSent = $mail->send();  
            // chcemy w ms
            $this->homePlTime =  (microtime(true) - $this->homePlTime) * 1000;
            if( !$this->emailSent ) { //nie wysłano - zapiszmy błąd
                $this->emailErr = $mail->ErrorInfo;
            }
        } else {
            //startowy log - gdy nic nie ma
            print("\n" . START_STR . date("Y-m-d, H:i:s"));
        }
    }
    
    // Posprzątaj na końcu
    public function clean() { 
        
        if( $this->rekord ) { // coś było wczytane z bazy
            if( $this->emailSent ) { //pomyślnie wysłany email
                print("\nE-mail OK");
                print("\nKonto --> " . $this->konto);
                $this->odnotujWdb(); // odznacz w bazie rekord, który został wysłany
            } else { //raportuj błąd wysłania e-maila
                print("\nE-mail NIE został wysłany.\n" . $this->emailErr);
            }
        } else {
            print("\nNothing to do....");
        }
        $this->conection = null;
    }
    
    private function odnotujWdb() { // odznacz w bazie rekord, który został wysłany
        
        $stmt = $this->conection->prepare(UQUERY . $this->rekord['id']);            
        $stmt->execute();
        //3 loguj wykonanie
        if( $stmt->rowCount() ) { 
            print("\nZapisano w bazie pomyślnie, id = " . $this->rekord['id']);
        } else {
            print("\nNie udało się zapisać w bazie");
        }
    }
    
    // ustawiamy główne parametry, poza odbiorcami tematem i trescią
    public function setMainEmailParams( $mail, $config ) { // $config - array z parametrami smtp
        // zakładamy, że $email to obiket PHPMailer'a
        $mail->isSMTP(); 
        //$mail->SMTPDebug  = 3;
        $mail->Timeout  =   20;
        $mail->CharSet = 'UTF-8';
        $mail->Host = $config['host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $config['username'];                 // SMTP username
        $mail->Password = $config['password'];                  // SMTP password
        //$mail->SMTPSecure = 'tls';                            //Enable TLS encryption, `ssl` also accepted
        $mail->SMTPAutoTLS = false;                             //wyłącza auto tls
        $mail->Port = $config['port'];                                   // TCP port to connect to
        //$mail->setFrom('skp@polskiekarty.pl', 'SKP');
        $mail->setFrom(key($config['from']), 'SKP');
        $mail->isHTML(true);                                  // Set email format to HTML
    }
    
    // ustaw odbiorców, temat i treść
    public function setRecsSubjectBody( $mail ) { // $rekord - wiersz z tablicy $events
        
        // dodajemy odbiorców         
        foreach( explode(" ", $this->rekord['odbiorcy']) as $adres ) {
            $mail->addAddress($adres); // dodaj wszystkie adresy e-mail;
        }            
        //$mail->addAddress('darek@polskiekarty.pl'); // Darek na razie zawsze dostaje
        $mail->Subject = $this->rekord['temat'];
        $url = $this->rekord['url']; 
        $post = nl2br($this->rekord['post']);        
        $mail->Body = "$post<br><br><a href=\"$url\">$url</a>";
    }
    
}

