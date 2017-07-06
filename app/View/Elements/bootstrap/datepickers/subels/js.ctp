
<script>
// powyzsze tylko w celu, by miec zakolorowany kod ponizej (by edytor kumal)
$('#<?php echo $id . " ." . $klasa; ?>').datepicker()
.on('changeDate', function(e) {
    //console.log(e.date);     
    <?php echo $hereval; ?>  = $('#<?php echo $id . " ." . $klasa; ?> input').val();
    
    //console.log(request.od.value);
    console.log(request);
});
//console.log(request);


