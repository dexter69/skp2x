
<script>
$('<?php echo $klasy . " #" .$config['id']; ?>').change(function(){
    <?php echo $config['acc']; ?> = $(this).val();
    console.log(request);
});



