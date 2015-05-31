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
            //$('#taken-date').val(dateText);
            $( "#datepicker" ).datepicker( "destroy" );
            // pokaż busy gif
            busy('on', item);
            var succes = zapiszDate(dateText, item);
            // destroy busy gif
            //setTimeout(function(){  
                busy('off', item);                
            //}, 1500);
            
            if( succes ) {
                setTimeout(function(){                      
                    $( item ).addClass( "persodate" );
                }, 1500);
            } else {
            /*             
             *  pokaż stosowny komunikat
             */    
            }
        }
    });    
}


function busy( mode, obj ) {
// mode on lub off    
    if( mode === 'on' ) {       
       $( obj ).addClass( "busy" );
       return;
    }
    $( obj ).removeClass( "busy" );
}

function zapiszDate_old( tekstZdata, obj ) {
// obj td, dd ....
    
    var zapisano = true;
    
    // taki obiekt mniej więcej będziemy otrzymywali od cake'e
    var backinfo = {
      termin: '2015-06-12',
      tshort: '17 cze'  
    };
    
    if( zapisano ) { //udało się w bazie zapisac  
        
        $( obj ).attr('title', $( obj ).text());
        //$( obj ).text( tekstZdata.substr(5, 5) );
        $( obj ).text(backinfo.tshort);
        return true;
    }
    
    return false;
}


function zapiszDate( tekstZdata, obj ) {
    
    var dane = {
        id: $(obj).data('id'),  // tu mamy id ustawianej karty
        stop_perso: tekstZdata  // i datę pobraną z kalendarza
    };
    
    var posting = $.post(
                        "/skp/2x/cards/addCzasPerso.json",
                        dane
                    );
    
    posting.done(function( data ) {
        if( data.result.saved ) {
            //alert('bingo!');
            $( obj ).text(data.result.stop_perso);
        } else {
            alert('nie zapisano ;-(');
        }
    });
    
    posting.fail(function( data ) {
         alert('fail!');
    });
    
}