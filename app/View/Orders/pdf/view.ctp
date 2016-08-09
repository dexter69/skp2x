<?php 
//nie dziala na linux'ie - update po ustawieniu w hosts apacz = 127.0.0.1 jest ok
// full base tutaj nie jest potrzebne - assetUrl działa OK
//echo '<pre>';	print_r( $order['Customer'] ); echo  '</pre>';

$fields = get_class_vars('DATABASE_CONFIG');
if( $dzial == SUA ) {    
    $mark = '(' . $fields['default']['ver'] . ') ';  
} else {
    $mark = null;
}

if( $fields['default']['ver'] == 'new' ) { // czy jesteśmy na nowym serwerze?
    // TAK - inny css
    echo $this->Html->css(array('order/order-pdf'), array('inline' => false));
} else { // w przeciwnym wypadku standard
    echo $this->Html->css(array('order-pdf'), array('inline' => false/*, 'fullBase' => true*/));
}
$karty = $this->Pdf->order_kartyTable( $order['Card'] ); 
$order['Order']['naklad'] = $karty['ilosc'];
$order['Order']['przedplata'] = $vju['forma_zaliczki']['options'][$order['Order']['forma_zaliczki']];
if( $order['Order']['procent_zaliczki'] ) {
    $order['Order']['przedplata'] .= ', ' . $order['Order']['procent_zaliczki'] . '%';
}
$order['Order']['forma'] = $vju['forma_platnosci']['options'][$order['Order']['forma_platnosci']];
if( ($order['Order']['forma_platnosci'] == PRZE || $order['Order']['forma_platnosci'] == CASH) && $order['Order']['termin_platnosci'] ) {
   $order['Order']['forma'] .= ', ' . $order['Order']['termin_platnosci'] . ' dni';
}

?>

<p class="czas-wydruku" ><?php echo $mark . "Czas wydruku: " . $this->Ma->mdt(date('Y-m-d H:i:s'), true); ?></p>
<div class="naglowek">
    <?php echo $this->Pdf->order_naglowekTable($order); ?> 
</div>

<div class="karty-pdf">
    <?php echo $karty['markup']; ?>
</div>

<div class="adresy-uwagi-pdf">
   <?php echo $this->Pdf->order_adresyUwagiTable($order); ?> 
</div>


<?php 

//echo '<pre>';	print_r($order); echo  '</pre>';
?>

