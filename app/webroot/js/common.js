//$( document ).ready(function() {
$(function() {    
    /*
     *  SZUKANIE
     */
    
    $(document).keypress(function(e) {
        if ( e.which === 102 && !$(e.target).is('input, textarea') ) {
            fireSearch();
        } 
    });

    $( '.klose-mark' ).click(function() {
        fireSearch();
    });
    
    /*
     *  PERSO - change date
     */
    $("td.changable, dd.changable").click(function() {
        interfejs( this );
        //alert($( this ).data('termin'));
    });
    
    

});

// Nazwy dni i miesięcy
var datoza = {
   miesiace : [
       "Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec",
       "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"
   ],
   dni : [ "Ni", "Po", "Wt", "Śr", "Cz", "Pt", "So"]
};
// do pomiaru szerokości
function checkSize() {

        var bodyw;
        var oknow;
        var wynik;

        bodyw = $( 'body' ).width();
        oknow = $(window).width();
        wynik = (oknow - bodyw)/2 +2;
        $( 'div#gener.actions' ).css( "left", wynik );

}	

function fireSearch() {

   if( $( '#szukanie' ).hasClass( 'hid' ) ) {
                $( '#szukanie' ).removeClass('hid');
                $( '#szukanie' ).addClass( 'vis');	
                $('#CardSirczname').click(function() {	
                        $(this).val('');
                });
                $('#CardSirczname').focus();
        } else {
                $( '#szukanie' ).removeClass('vis');
                $( '#szukanie' ).addClass( 'hid');	
        } 

}

/*
     *  PERSO - change date
     */
    
function tmp() {
    alert("Haribol!");
}

function interfejs( item ) {
    //alert( item );
    //var theid = $(item).find('.kalendar-wraper > div').attr('id');
    //alert(typeof theid);
    
    $( "#datepicker" ).datepicker({
        dateFormat: "yy-mm-dd",
        defaultDate: $( item ).data('termin'), //pobieramy ustawioną datę, przechowywaną w atrybucie
        firstDay: 1, //w Polsze pierwszym dniem tygodnia jest pon
        monthNames:  datoza.miesiace,
        dayNamesMin: datoza.dni,
        onSelect: function(dateText) {
            $('#taken-date').val(dateText);
            $( "#datepicker" ).datepicker( "destroy" );
            // pokaż busy gif
            if( zapiszDate(dateText) ) {
            // udało się zapisać wybraną datę
            /*
             *  destroy busy gif,
             *  zmień datę w td/dd (i odpowiedznie klasy)
             */
            } else {
            /*
             *  destroy busy gif,
             *  pokaż stosowny komunikat
             */    
            }
        }
    });
    
    $('#datepicker table td').click(function() {	
        //alert('Gibon');
        //var currentDate = $( "#datepicker" ).datepicker( "getDate" );
        //$('#taken-date').val(currentDate);
    });
    
    $('#taken-date').change(function() {	
        //alert('Gibon');
        //var currentDate = $( "#datepicker" ).datepicker( "getDate" );
        //$('#taken-date').val(currentDate);
    });
    
    //$( "#" + theid ).datepicker();
}

function zapiszDate( tekstZdata ) {
    
    return true;
}