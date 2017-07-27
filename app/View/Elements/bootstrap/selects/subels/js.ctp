<script>
$('#<?php echo $id; ?>' + ' .dropdown-menu li').click( function () { 
    // wartosc z listy do obiektu request 
    <?php echo $acc; ?> = $(this).attr("value");  
    
    // Wpisz odpowiedni tekst do buttona
    $('#<?php echo $id; ?>' + ' button').html(
      $(this).text() + ' <span class="caret"></span>'
    );
    // "Odkryj ukryty element"
    $('#<?php echo $id; ?>' + ' .dropdown-menu > li.schowaj').toggleClass( "schowaj" );
    // "Schowaj klikniety element"
    $( this ).toggleClass( "schowaj" );
});
// Wartosc poczatkowa
<?php echo $acc; ?> = $('#<?php echo $id; ?>' + ' button').data("value"); 



