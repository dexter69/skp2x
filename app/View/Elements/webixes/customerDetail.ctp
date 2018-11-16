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
</div>