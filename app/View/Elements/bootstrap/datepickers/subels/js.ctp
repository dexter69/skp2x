
<script>
$('<?php echo $klasy; ?>').datepicker()
    .on('hide', function(e) {
        //console.log("Gibon!");     
        <?php echo $config[0]['acc']; ?>  = $('<?php echo $klasy . " #" .$config[0]['id']; ?>').val();

        <?php
            if( count($config) > 1 ) { // znaczy 2 pickery
                echo $config[1]['acc']; ?>  = $('<?php echo $klasy . " #" .$config[1]['id']; ?>').val();
        <?php
            }
        ?>
        // Po zmianie daty, odpal szukanie - komunikację z serwerem
        // UWAGA !!! nazwa tej funkcji musi być zgodna z tą w pliku search.js
        fireSearch();
});

