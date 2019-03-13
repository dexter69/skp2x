<?php
if( $order['Order']['newcustomer'] ) { $rodz = " [N]"; } else { $rodz = " [S]"; }
$klient = $this->Html->link( $order['Customer']['name'], [
    'controller' => 'customers',
    'action' => 'view',
    $order['Customer']['id']
]) . "<span class='rodzcust'>$rodz</span>";

$userName = $order['User']['name'];

// PRZEDPŁATA
$prepaidDtDd = $this->element('orders/view/pre-dt-dd', $prepaid_table );

$forma = $vju['forma_platnosci']['options'][$order['Order']['forma_platnosci']];
if(
    $order['Order']['termin_platnosci'] &&
    ($order['Order']['forma_platnosci'] == PRZE || $order['Order']['forma_platnosci'] == CASH)) {
    $forma .= ", {$order['Order']['termin_platnosci']} dni";
}

$waluta = $order['Customer']['waluta'];

$status = $this->Ma->status_zamow($order['Order']['status']);

$doFaktury = $this->Ma->adresFaktury($order);

$adresDostawy = $this->Ma->adresDostawy($order);

$kontakt = "{$order['Order']['osoba_kontaktowa']} <br>tel. {$order['Order']['tel']}";



?>

<dl id="dexview" class="in-order">

    <dt>Klient</dt>
    <dd><?php echo $klient; ?>&nbsp;</dd>

    <dt>Opiekun</dt>
    <dd><?php echo $userName; ?>&nbsp;</dd>

    <?php echo $prepaidDtDd; ?>

    <dt>Forma Płatnosci</dt>
    <dd><?php echo $forma; ?>&nbsp;</dd>

    <dt>Waluta</dt>
    <dd><?php echo $waluta; ?>&nbsp;</dd>

    <dt>Status</dt>
    <dd><?php echo $status; ?>&nbsp;</dd>

    <dt>Dane do faktury</dt>
    <dd><?php echo $doFaktury; ?>&nbsp;</dd>

    <dt>Adres dostawy</dt>
    <dd><?php echo $adresDostawy; ?>&nbsp;</dd>

    <dt>Kontakt</dt>
    <dd><?php echo $kontakt; ?>&nbsp;</dd>

</dl>

<div class="order-uwagi">
    <p>Uwagi:</p>
    <?php echo nl2br($order['Order']['comment']); ?>&nbsp;
</div>