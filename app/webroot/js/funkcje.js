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
 *  Funkcje do zmiany daty perso
 *  
 */

function busy( mode, obj ) {
// mode on lub off    
    if( mode === 'on' ) {       
       $( obj ).addClass( "busy" );
       return;
    }
    $( obj ).removeClass( "busy" );
}

function zapiszDate( tekstZdata, obj, longoza, url ) {
    
    var dane = {
        id: $(obj).data('id'),  // tu mamy id ustawianej karty
        stop_perso: tekstZdata,  // i datę pobraną z kalendarza
        dl: longoza             // czy chcemy spowrotem długą, czy krótką datę
    };
    
    //pokaż busy gif;
    busy('on', obj);
    
    //"/skp/2x/cards/addCzasPerso.json",
    //"/skp/cards/addCzasPerso.json",
    
    var posting = $.post( url, dane );
    
    posting.done(function( data ) {
        busy('off', obj);
        if( data.saved ) {
            $( obj ).text(data.stop_perso);
            $( obj ).addClass( "persodate" );
            $( obj ).data("termin", tekstZdata);
        } else {
            komunikat('Niestety nie udało się zmienić daty...', '-210px');
        }
    });
    
    posting.fail(function( data ) {
        busy('off', obj);        
        komunikat('Oops... coś poszło nie tak ...', '-170px');
    });
}

function komunikat( str, mleft ) {
    $('#komunikat').html( str + '<p>(kliknij, żeby zamknąć)</p>' );
    $('#komunikat').css('margin-left', mleft);
    $('#komunikat').addClass('pokaz');
    $('#komunikat').click(function() {
       $(this).text('');
       $(this).removeClass('pokaz');
    });
}


function interfejs( item, dlugosc, url ) {
    
    // Nazwy dni i miesięcy
    var datoza = {
       miesiace : [
           "Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec",
           "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"
       ],
       dni : [ "Ni", "Po", "Wt", "Śr", "Cz", "Pt", "So"]
    };    
    
    $( "#datepicker" ).datepicker({
        dateFormat: "yy-mm-dd",
        defaultDate: $( item ).data('termin'), //pobieramy ustawioną datę, przechowywaną w atrybucie
        firstDay: 1, //w Polsze pierwszym dniem tygodnia jest pon
        monthNames:  datoza.miesiace,
        dayNamesMin: datoza.dni,
        minDate: 0,
        onSelect: function(dateText) {
            $( "#datepicker" ).datepicker( "destroy" );
            zapiszDate(dateText, item, dlugosc, url);
        }
    });    
}

