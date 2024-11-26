<?php if($departament == SUA) { ?>
    <a href="/db" target="_blank" class="layout-link"><i class="fa fa-database" aria-hidden="true"></i></a>
<?php } ?>
<?php if($departament == SUA || $departament == KOR) { ?>
    <a href="/szukaj" target="_blank" class="layout-link"><i class="fa fa-search" aria-hidden="true"></i></a>
<?php } ?>
<?php
    if($departament == PER || $departament == KON || $departament == DTP || $departament == SUA) {
        if( $jobnumer ) {
            $link = '/etykiety/' . $jobnumer;
        } else {
            $link = "/etykiety";
        }
?>

    <a href="<?php echo $link ?>" target="_blank" class="layout-link"><i class="fa fa-tags" aria-hidden="true"></i></a>
<?php } ?>
