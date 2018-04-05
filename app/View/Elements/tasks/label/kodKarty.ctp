<div class="<?php echo $divclass;?>">
<?php

//dodatkowe pseudo atrybuty
$ext ='act="' . $karta['active'] . '" nor="' . $karta['normal'] . '"';
?>
    <h3 class="<?php echo $karta['hclass']; ?>"
        data-product="<?php echo $karta['name']; ?>"
        data-naklad="<?php echo $karta['naklad']; ?>"
        data-produkcyjne="<?php echo $produkcyjne; ?>"
        data-handlowe="<?php echo $karta['hnr']; ?>"
        data-lang="<?php echo $karta['etylang']; ?>">          
        <?php echo $karta['nazwa']; ?>
    </h3>
    <p class="infobar baton">
        <span class="switch"><button class="btn btn-primary" type="button">&nbsp;&nbsp;baton&nbsp;&nbsp;</button></span>
        nakład: <strong><?php echo $karta['naklad']; ?></strong>        
    </p>
    <ul <?php echo $ext;?> class="list-inline kod-karty"><?php
        foreach( $box as $key => $val ) {
            if( $karta['kontrol']['active'] == $key ) { // ten "klikacz" ma być aktywny
                echo '<li class="' . $karta['active'] . '" ' . $ext . ' data-q="' . $parcel[$key] . '">' . $val . '</li>';
            } else {
                echo '<li class="' . $karta['normal'] . '" ' . $ext . ' data-q="' . $parcel[$key] . '">' . $val . '</li>';
            }
        }
    ?>
        <li class="bg-info input"><input type="text" class="form-controlx" value="<?php echo $karta['kontrol']['input'];?>" <?php echo $karta['linput'];?>></li>
    </ul>    
    
    <?php
        // Chcemy tylko osobom z działu Perso (i innym, które potrzebują) wyświetlać formularz do zakresów
        if(  $properDzial && $karta['etykieta'] == 'zakres' ) {
            echo $this->element('tasks/label/zakres', [
                'etyk' => $karta['etykieta'],
                'id' => $karta['id']
            ]);
        }                
    ?>  
    
</div>