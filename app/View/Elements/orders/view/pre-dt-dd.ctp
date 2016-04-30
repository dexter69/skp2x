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
    <p class="pay-info">
        <span id="span1"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
        <span id="span2"></span>
        <span id="span3"></span>
    </p>
</dd>