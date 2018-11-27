<?php
    if( $valBold ) {
        $stl = '<strong>';
        $stp = '</strong>';
    } else {
        $stl = $stp = "";
    }
    $mainClass = "left-right-elem";
    if( isset($extraClass) ) {
        $mainClass .= "@$extraClass";
    }
?>
<div @class="<?php echo $mainClass ?>">
    <div @class="table">
        <?php
            foreach($dane as $etyk => $val) {
                echo '<div @class="table-row">';
                    echo "<div @class=\"table-cell @etykieta\">{$etyk}:</div>";                
                    echo "<div @class=\"table-cell @value\">{$stl}{$val}{$stp}</div>";
                echo '</div>';
            }
        ?>
    </div>
</div>



