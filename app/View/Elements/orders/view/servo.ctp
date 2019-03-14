<?php
// <!-- Kontrolka do otwierania zamówień w trybie serwisowym -->
$theIkonka =
//"fa-undo"
"fa-cubes"
;

// Zakładamy, że $servoValue jest > 0
if( $servoValue == SERVO_VIS ) { // tylko widoczne
    $spnaId = "servo-span-vis";
    $spanTitle = "Zamówienie zawiera serwisowane karty";
} else { // zostaje tylko SERVO_CLI - czyli widoczne i klikalne
    $spnaId = "servo-span";
    $spanTitle = "Otwórz w trybie serwisu";
}
?>
<span id="<?php echo $spnaId; ?>" class="servo" title="<?php echo $spanTitle; ?>">
    <i class="fa <?php echo $theIkonka;?>" aria-hidden="true"></i>
</span>

<span id="servo-spinner-span" class="servo ukryty">
    <i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>
</span>