<?php
$start = count($order['Event'])-1;
$lis = "";
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
    $klaska = $evtext[$event['co']]['class'];
    $whatDid = "{$evtext[$event['co']][$ludz[$event['user_id']]['k']]} $co$kartkomm";
    $datka = $this->Ma->mdt($event['created']);

    $poscik = nl2br($event['post']);
    $licznik = $i + 1;

    $lis .= $this->element('orders/view/ul_events/li',[
        'imieLudzia' => $imieLudzia,
        'klaska' => $klaska,
        'whatDid' => $whatDid,
        'datka' => $datka,
        'poscik' => $poscik,
        'licznik' => $licznik
    ]);

}
?>


<div class="ul-events">
    <?php $this->Ma->kontrolka_ord($order, $evcontrol);?>
    <ul>
        <?php echo $lis;?>
    </ul>
</div>



    