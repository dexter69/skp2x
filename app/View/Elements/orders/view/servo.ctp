<?php
// <!-- Kontrolka do otwierania zamówień w trybie serwisowym -->
$theIkonka =
//"fa-undo"
"fa-cubes"
;
?>
<span id="servo-span" class="servo" title="Otwórz w trybie serwisu">
    <i class="fa <?php echo $theIkonka;?>" aria-hidden="true"></i>
</span>

<span id="servo-spinner-span" class="servo ukryty">
    <i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>
</span>