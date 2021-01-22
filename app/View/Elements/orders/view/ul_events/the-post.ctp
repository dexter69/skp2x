<?php
    /* zkładamy, że $posciki zawiera conajmniej 1 element, nawet jeżeli uż. nic nie napisał,
    to mamy element z pustym stringiem */

    $size = count($posciki);
    $msg_body = "";
    if(  $size > 1 ) { 
        // Skonstruuj pozostałe, starsze wersje posta i doklej do $msg
        $msg = '<ul class="wersja">';         
        for( $i=1; $i<$size; $i++ ) {                
            $msg_body .= '<span class="old-msg no-' . $i .'">' . $posciki[$size - $i] . '</span>';
            $msg .= $this->element('orders/view/ul_events/sub_li', ["item" => $i, "klasa" => "cyferka"]);           
        }
        $msg .= $this->element('orders/view/ul_events/sub_li', ["item" => "starsze wersje:", "klasa" => "tekst"]); 
        $msg .= '</ul>';
        $msg .= '<p class="ekstra-msgs">' . $msg_body . '</p>';
    } else {
        $msg = '';
    }    
?>
<ol class="olevent"><li><?php echo $posciki[0]; ?></li></ol>        
<?php echo $msg; ?>  