<?php
    if( $klasa_li == "" ) {
        $strcl = "";
    } else {
        $strcl = 'class="' . $klasa_li . '"';
    }
?>
<li <?php echo $strcl?>>
    <span class="<?php echo $klasa;?>"><?php echo $item; ?></span>
</li>