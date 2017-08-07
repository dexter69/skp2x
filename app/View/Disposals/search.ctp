<?php
    $ile = count($disposals);
    if($ile) {
        $tekst = "<p>Ilość rekordów: <b>$ile</b></p>";
    } else {
        $tekst = "<p><b>Nie</b> znaleziono żadnych wyników!</p>";
    }
    echo $tekst;
    
?>
<pre>
    <?php print_r($data); ?>
</pre>
<pre>
    <?php print_r($disposals); ?>
</pre>
