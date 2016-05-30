<?php 
   
if( $stan_zaliczki == null ) {
    $klasa_ext = 'null';
    
} else {
    $klasa_ext = $stan_zaliczki;
} 
//$klasa_ext .= ' open';
if( $clickable ) { $klasa_ext .= ' clickable'; }
?>

<dt><?php echo 'Przedpłata' ?></dt>
<dd id="the-dd"
    class="pre-paid <?php echo $klasa_ext?>"
    base="<?php
                echo $this->webroot; // info o url
          ?>"
    order_id="<?php
                echo $id; // id zamówienia
          ?>"
    >
    <?php echo $prepaid; ?>&nbsp;    
</dd>