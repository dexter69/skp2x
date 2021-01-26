<?php
    //echo '<pre>' . print_r($posciki) . '</pre>';
    $aktualny = $posciki[0];    
    $wszystkie = ZNACZNIK_MSG . implode(ZNACZNIK_MSG, $posciki);
    $errmsg = "Ooopsss...<br>Nie udało się zapisać!";

?>
<div class="fix-div" data-evid="<?php echo $evid ?>">
    <!-- id="w3review" name="w3review" rows="4" cols="50" -->
    <!-- Wrzuć do input'a bierzący post -->
    <form>
        <textarea><?php echo $aktualny; ?></textarea>
        <div>
            <button type="button" value="save" data-evid="<?php echo $evid ?>" data-znacznik="<?php echo ZNACZNIK_MSG ?>">ZAPISZ</button>
            <button type="button" value="cancel" data-evid="<?php echo $evid ?>">Anuluj</button>
        </div>
    </form>
    <!-- Kręcioła  -->
    <div class="kreciola"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
    <!-- Error msg  -->
    <div class="errmsg">
        <div><?php echo $errmsg; ?></div>
        <p><a href="javascript:void(0)" title="Zamknij">&times;</a></p>
    </div>
    <!-- A tu wszystkie, łącznie z bierzącym -->
    <p class="all"><?php echo $wszystkie; ?></p>
    <!-- A tu aktualny post, przed zmianą -->
    <p class="aktualny"><?php echo $aktualny; ?></p>
</div>