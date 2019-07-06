<?php
    /** 
     * Używamy znaku '@' dla oznaczenia spaji. Metoda $this->App->trimAll,
     * wywala wszystkie białe znaki i zastępuje '@' spacją */

    $fullName = "#{$vars['siedziba']['fullName']}#";
    $ulString = "#{$vars['siedziba']['ulica']}#@#{$vars['siedziba']['nr']}#";
    $cityString = "#{$vars['siedziba']['kod']}#@#{$vars['siedziba']['miasto']}#";
    $krajString = "#{$vars['siedziba']['kraj']}#";
    $nipString = "NIP:@#{$vars['siedziba']['nip']}#";
?>
<div @class="<?php echo $class; ?>">
    <div @class="siedziba">
        <h3><?php echo "$fullName";?></h3> 
        <p @class="ul-string"><?php echo "$ulString"; ?></p>
        <p @class="city-string"><?php echo "$cityString"; ?></p>
        <p @class="kraj-string"><?php echo "$krajString"; ?></p>
        <p @class="nip-string"><?php echo "$nipString"; ?></p>
    </div>
    <div @id="lof-id" @class="list-of-links"><span>Linki:</span>
        <?php
            for( $i=0; $i<$vars['maxUpLinks']; $i++ ) {            
                //Nie mam pojęcia, czemu nie mogę tu użyć '', tylko trzeba escape'ować
                // Prawdopodobnie coś z trimAll
                echo "<p @class=\"link-item\"><a @target=\"_blank\" @href=\"" . uplBase . "#link$i#\">#link$i#</a></p>";
            }
        ?>
    </div>    
    <!-- we want add extra button and this is placeholder -->
    <div @id="link-producer"></div>
</div>
<?php
    // Płatności
    echo $this->element("webixes/leftRightTable", [
        'extraClass' => 'elemOfCustDetail',
        'valBold' => true, // czy wartości po prawej mają być bold
        'dane' => [ // etykieta => wartość
            'zaliczka' => '#WebixCustomer_forma_zaliczki_txt#',
            'forma' => '#WebixCustomer_forma_platnosci_txt#',
            'waluta' => '#WebixCustomer_waluta#'
        ]
    ]);
    // @ robi za spację => patrz App->trimAll
    echo $this->element("webixes/leftRightTable", [
        'extraClass' => 'elemOfCustDetail',
        'valBold' => true, // czy wartości po prawej mają być bold
        'dane' => [ // etykieta => wartość
            'czas@realizacji' => '#WebixCustomer_cr#',
            'stały@opiekun' => '#WebixCustomerRealOwner_name#',
            'język@etykiety' => '#WebixCustomer_etylang_txt#'
        ]
    ]);
?>
#WebixCustomer_comment#
