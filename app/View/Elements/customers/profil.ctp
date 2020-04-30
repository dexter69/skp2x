<?php
//echo '<pre>'; echo print_r($customer); echo '</pre>';
$check = $this->Order->findCurly($customer['comment']);
$uwagi = $check['rest']; // Albo wydzielone albo całe - zawsze tu są
$wazne = $check['curly']; // Gdy nie ma przypominajki, to jest tu false

// Klasy elemenu/elementów uwagi/important w zależności, czy mamy important/przypominajka
if( $wazne ) { // Znaczy, że jest jakaś przypominajka    
    $uwagiClass = $wazneClass = "col-sm-6";
} else {
    $uwagiClass =  "col-sm-12";
    $wazneClass ="hidden";
}

?>
<?php  ?>
<div class="row">
    <div class="col-sm-6">
        <div class="customer-block">
            <span class="label label-default label-big">Adres siedziby</span>
            <address>
              <strong><?php echo $siedziba['name']; ?></strong><br>
              <?php echo $siedziba['ulica'] . ' ' . $siedziba['nr_budynku'] ?><br>
              <?php echo $siedziba['kod'] . ' ' . $siedziba['miasto'] ?><br>
              <?php echo $siedziba['kraj']; ?>
            </address>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="customer-block">
           <span class="label label-default label-big">Płatności</span>
           <p>
               zaliczka:&nbsp;<strong><?php echo $customer['forma_zaliczki_txt']; ?></strong>
               <?php
               if( $customer['forma_zaliczki'] != BRAK ) {
                   echo '<strong>&nbsp;' . $customer['procent_zaliczki'] .  '%</strong>';
               }
               ?>
               <br>
               forma:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $customer['forma_platnosci_txt']; ?></strong><br>
               waluta:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $customer['waluta']; ?></strong><br>
               NIP:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $customer['vatno_txt']; ?></strong>
           </p>
        </div>
    </div> 
    <div class="col-sm-6">
        <div class="customer-block">
            <span class="label label-default label-big">Kontakt</span><br>
            <p>
                <strong><?php echo $customer['osoba_kontaktowa']; ?></strong><br>
                <?php echo $customer['tel']; ?><br>        
                <a href="mailto:<?php echo $customer['email']; ?>"><?php echo $customer['email']; ?></a>
            </p>    
        </div>
    </div>
    <div class="col-sm-6">
        <div class="customer-block">
            <span class="label label-default label-big">Inne</span>
            <p>
                czas realizacji:&nbsp;<strong><?php echo $customer['cr']; ?> dni</strong><br>                
                język etykiety:&nbsp;<strong><?php echo $customer['etylang-txt']; ?></strong><br>
                pozyskany:&nbsp;<strong><?php echo $customer['pozyskany']; ?></strong><br>
                opiekun:&nbsp;<strong><?php echo $opiekun; ?></strong>
            </p>
        </div>
    </div>
    <div class="<?php echo $uwagiClass ?>">
        <div class="customer-block">
            <span class="label label-default label-big">Uwagi</span>
            <p><?php echo nl2br( $uwagi ) ?></p>  
        </div>
    </div>
    <div class="<?php echo $wazneClass ?>">
        <div class="customer-block">
            <span class="label label-warning label-big">Pamiętać przy zamówieniu !</span>
            <p><?php echo nl2br( $wazne ); ?></p>  
        </div>
    </div>    
</div>
<?php
//echo '<pre>'; print_r($customer); echo '</pre>';$customer['comment']
//echo '<pre>'; print_r($siedziba); echo '</pre>';
//echo $this->App->print_r2($check);