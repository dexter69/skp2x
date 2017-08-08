<div class="col-md-12">
    <?php
        define('IIR', 12); // ile winików w jednym wierszu -> 12, bo 12 kolumn w bootstrap
        $ile = count($disposals);
        if($ile) {
            $tekst = "<p>Ilość rekordów: <b>$ile</b></p>";
        } else {
            $tekst = "<p><b>Nie</b> znaleziono żadnych wyników!</p>";
        }
        echo $tekst;
        
    ?>
</div>
<div class="col-md-12">
    <pre>
        <?php print_r($data); ?>
    </pre>
</div>
<?php    
    $offset = 0;
    while( $offset < $ile ) {
        echo $this->element('disposals/outdata', [
            'offset' => $offset,
            'max' => IIR,
            'data' => $disposals
        ]);
        $offset += IIR;
    }
?>
<div class="col-md-12">
    <pre>
        <?php print_r($disposals); ?>
    </pre>
</div>