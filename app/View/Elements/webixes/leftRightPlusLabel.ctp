<?php
    if( $valBold ) {
        $stl = '<strong>';
        $stp = '</strong>';
    } else {
        $stl = $stp = "";
    }
?>
<div @class="left-right-elem">
    <div @class="table">
        <div @class="table-row">
                <div @class="table-cell @etykieta">zaliczka:</div>
                <div @class="table-cell @value"><?php echo $stl . "brak" . $stp; ?></div>                
        </div>
        <div @class="table-row">
                <div @class="table-cell @etykieta">forma:</div>
                <div @class="table-cell @value"><?php echo $stl . "przelew" . $stp; ?></div>                
        </div>
        <div @class="table-row">
                <div @class="table-cell @etykieta">waluta:</div>
                <div @class="table-cell @value"><?php echo $stl . "EUR" . $stp; ?></div>                
        </div>
    </div>
</div>