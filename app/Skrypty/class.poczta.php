<?php

/* 
 * Przydatne rzeczy
 */

class POCZTA {
    
    // ustawiamy główne parametry, poza odbiorcami tematem i trescią
    public function setMainEmailParams( $mail, $config ) { // $config - array z parametrami smtp
        // zakładamy, że $email to obiket PHPMailer'a
        $mail->isSMTP(); 
        $mail->SMTPDebug  = 3;
        $mail->Timeout  =   30;
        $mail->CharSet = 'UTF-8';
        $mail->Host = $config['host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $config['username'];                 // SMTP username
        $mail->Password = $config['password'];                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Nie chce na razie szyfrowania //Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                   // TCP port to connect to
        //$mail->setFrom('skp@polskiekarty.pl', 'SKP');
        $mail->setFrom(key($config['from']), 'SKP');
        $mail->isHTML(true);                                  // Set email format to HTML
    }
    
    // ustaw odbiorców, temat i treść
    public function setRecsSubjectBody( $mail, $rekord ) { // $rekord - wiersz z tablicy $events
        
        // dodajemy odbiorców    
        //$body = null;
        foreach( explode(" ", $rekord['odbiorcy']) as $adres ) {
            $mail->addAddress($adres); // dodaj wszystkie adresy e-mail;
            //$body .= "- $adres<br>";
        }
        $mail->addAddress('darek@polskiekarty.pl'); // Darek na razie zawsze dostaje
        $mail->Subject = $rekord['temat'];
        $url = $rekord['url']; 
        $post = nl2br($rekord['post']);        
        $mail->Body = "$post<br><br><a href=\"$url\">$url</a>";
    }
    
}

