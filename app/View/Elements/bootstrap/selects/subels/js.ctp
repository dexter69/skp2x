<script>
$('#<?php echo $id; ?>' + ' .dropdown-menu li').click( function () {  
    <?php echo $acc; ?> = $(this).attr("value");  
    $('#<?php echo $id; ?>' + ' button').html(
      $(this).text() + ' <span class="caret"></span>'
    );
});
// Wartosc poczatkowa
<?php echo $acc; ?> = $('#<?php echo $id; ?>' + ' button').data("value"); 



