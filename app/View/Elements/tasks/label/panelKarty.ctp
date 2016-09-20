<div class="<?php echo $divclass?>">
<?php

/*  Na razie tu dajemy zmienną przechowującą dane do wersji polskiej i ang etykiety
    Jak będzie taka potrzeba, to przeniesiemy do np. helper'a */
$lan = array(
    'nazwa' => array('pl' => 'nazwa', 'en' => 'name')
);

// klasy "klikaczy
$active = 'bg-primary';
$normal = 'bg-info';

//dodatkowe pseudo atrybuty
$ext ='act="' . $active . '" nor="' . $normal . '"';
?>
    <h3 class="name">        
        <?php 
            echo $this->Html->link(
                $karta['name'], 
                array('controller' => 'tasks', 'action' => 'lpdf'),
                array('class' => 'etykpdf', 'target' => '_blank')//,  'escape' =>false)
            );?>
    </h3>
    <ul class="list-inline"><?php
        foreach( $box as $key => $val ) {
            if( $karta['kontrol']['active'] == $key ) { // ten "klikacz" ma być aktywny
                echo '<li class="' . $active . '" ' . $ext . '>' . $val . '</li>';
            } else {
                echo '<li class="' . $normal . '" ' . $ext . '>' . $val . '</li>';
            }
        }
    ?>
        <li class="bg-info input"><input type="text" class="form-controlx" value="<?php echo $karta['kontrol']['input'];?>"></li>
    </ul>
</div>