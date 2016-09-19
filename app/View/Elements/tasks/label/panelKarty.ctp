<div class="<?php echo $divclass?>">
<?php

/*  Na razie tu dajemy zmienną przechowującą dane do wersji polskiej i ang etykiety
    Jak będzie taka potrzeba, to przeniesiemy do np. helper'a */
$lan = array(
    'nazwa' => array('pl' => 'nazwa', 'en' => 'name')
);
$kl = 'bg-primary';
?>
    <h3 class="name"><?php echo $karta['name']; ?></h3>
    <ul class="list-inline"><?php
        foreach( $box as $key => $val ) {
            echo '<li class="' . $kl . '">' . $key . '</li>';
            $kl = 'bg-info';
        }
    ?>
        <li class="bg-info input"><input type="text" class="form-controlx" id="abc"></li>
    </ul>
</div>