
<script>
$('<?php echo $klasy; ?>').datepicker()
    .on('changeDate', function(e) {
        //console.log(e.date);     
        <?php echo $config[0]['acc']; ?>  = $('<?php echo $klasy . " #" .$config[0]['id']; ?>').val();

        <?php
            if( count($config) > 1 ) { // znaczy 2 pickery
                echo $config[1]['acc']; ?>  = $('<?php echo $klasy . " #" .$config[1]['id']; ?>').val();
        <?php
            }
        ?>
});

