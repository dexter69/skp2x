<?php
//echo $this->App->print_r2($order['Event']);
$start = count($order['Event'])-1;
$lis = "";
$fixForms = ""; // Formularze do edycji zdarzeń
for ($i = $start; $i >=0; $i--) {
    $event = $order['Event'][$i];
    switch( $event['co'] ) {
        case put_kom: $co ='';
        break;
        case p_ov:
        case p_no: 
        case p_ok: 
        case d_no: 
        case d_ok:
        case h_ov: 
            if(	array_key_exists( $event['card_id'], $karty ) ) {
                    $co = $karty[$event['card_id']];
            } else {
                    $co = "(USUNIĘTA)";
            }                                             
        break;
        default:    $co ='';
    }
    
    if( $event['co'] == put_kom && $event['card_id']  ) {
        $kartkomm = ' odnośnie karty:';
        foreach( $order['Card'] as $karta ) {
            if( $karta['id'] == $event['card_id'] ) { $kartkomm .= ' ' . $karta['name']; }                
        }
    } else {
        $kartkomm = null;
    }
    $imieLudzia = $ludz[$event['user_id']]['name'];
    $fix = $ludz[$event['user_id']]['fix'];
    $klaska = $evtext[$event['co']]['class'];
    $whatDid = "{$evtext[$event['co']][$ludz[$event['user_id']]['k']]} $co$kartkomm";
    $datka = $this->Ma->mdt($event['created']);
    $evid = $event['id']; // id eventu w bazie

    /*  W większości wypadków jest to jeden post.
        Czasami przy edytowanych będzie to conajmniej 2 (obecny i poprzedni) */
    $posciki = $this->Ma->convertEventMsgs($event['post']);
    
    $licznik = $i + 1;

    $lis .= $this->element('orders/view/ul_events/li',[
        'imieLudzia' => $imieLudzia,
        'klaska' => $klaska,
        'whatDid' => $whatDid,
        'datka' => $datka,        
        'posciki' => $posciki,
        'licznik' => $licznik,
        'fix' => $fix, // czy może edytować swój post
        'evid' => $evid
    ]);

    // Dodaj formularz edycji zdarzenia, jeżeli takowe, edytowalne zdarzenie istnieje
    if( $fix ) {
        $fixForms .= $this->element('orders/view/ul_events/fix-form',[
            'posciki' => $posciki,
            'evid' => $evid
        ]);
    }
}
?>


<div class="ul-events">
    <?php $this->Ma->kontrolka_ord($order, $evcontrol, $przypominajka );?>
    <ul>
        <?php echo $lis;?>
    </ul>
</div>

<!-- Blok ewentualnych formularzy do edycji zdarzeń -->
<div class="fix-block">
    <?php echo $fixForms;?>
</div>



    