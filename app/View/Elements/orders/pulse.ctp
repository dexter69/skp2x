<?php 
/**
 * Reminder about important things during order creation
 * thanks to https://www.florin-pop.com/blog/2019/03/css-pulse-effect/ * */
$klasa = "przypominajka";
if( !$widoczne ) {
    $klasa .= " off";
}

if( $title ) {
    $rest = ' title="' . $title . '"';
} else {
    $rest = null;
}
?>
<div class="<?php echo $klasa ?>"<?php echo $rest?>></div>



