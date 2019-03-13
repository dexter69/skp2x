<?php $klasa = ($isleft ? "isleft" : ""); ?>
<table cellpadding = "0" cellspacing = "0" class="<?php echo $klasa; ?>">

    <tr>
        <th class="card_id_fix">Id</th>
        <th>Nazwa</th>
        <th class="card_opcje_fix">Opcje</th>		
        <th class="card_zlec_fix">Zlecenie(P)</th>		
        <th class="card_ilosc_fix">Ilość</th>
        <th class="card_ilosc_fix_mag"></th>
        <th class="card_cena_fix">Cena</th>
        <th class="<?php echo $ta_klasa; ?>">Status</th>
        <?php echo $extraTh ?>			
    </tr>

    <?php
    echo $tbody['html'];
    if( $tbody['sigma'] ) {
        $style = "";    
    } else {
        $style = "display: none;";
    }
    ?>
    <tr class="sumainfo" style="<?php echo $style; ?>">
        <td></td>
        <td></td>
        <td></td>
        <td class="sumatd">Suma:</td>
        <td class="card_ilosc_fix"><?php echo $tbody['sigma']; ?></td>
        <td></td>
        <td></td>
    </tr>

</table>
