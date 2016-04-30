/* 
 Obsługa oznaczania płatności
 */

// da się kliknąć przy określonej kombinacji klas
var pole_z_kareta = "dl > #the-dd.clickable .pay-info > #span1";
var theDD = "dl > #the-dd"; //interesujący nas element dd, w ktorym jest widget

// tu nie rozróżniamy, czy ma klasę clickable, po prostu robimy obsługę kliknięcia
// dla tego spana
var klik_span = "dl > #the-dd .pay-info > #span1";

//var prePaidInfo = {}; // obiekt z informacjami o stanie przedpłaty

$( document ).ready(function() {
    
    // zasysnij aktualne dane i uaktualnij DOM
    getInfoFromServer();
    
    obslugaKliknieciaW_Karete();
    
    
    
    
    // <<<<<<<<<<<<<< Stare testy
    // zasysamy kod z szablonu - template
    //var theCode = $("[name=pre-paid]").html();    
    // wrzucamy d dd (na razie testowo)
    //$("#the-dd").html(theCode);
    
});

// Klikamy o ile się da w pole obsługi prepaid
function obslugaKliknieciaW_Karete() {
    
    $(pole_z_kareta).click( function(){
        
        //getInfoFromServer(); //uaktualnij stan przedpłaty
        
        //$(theDD).toggleClass("open");
        
        
        if( widgetZamkniety() ) {
            console.log('zamkniety');
            // uaktualnij stan przedpłaty, aktualizować potrzebujemy tylko gdy otwieramy
            getInfoFromServer(); 
        } else {
            console.log('otwarty');
        }
        /**/
        
        
        
    });
}

// zwraca prawdę, jeżeli widget jest rozwinięty
function widgetZamkniety() {    
    return !$(theDD).hasClass( "open" );
}

// Zasysamy z serwera info o stanie przedpłaty i uaktualniamy DOM
function getInfoFromServer() {
    
    var url = $(theDD).attr("base") + "orders/prepaid.json";
    var order_id = $(theDD).attr("order_id");
    
    //console.log("url = " + url );
    
    var posting = $.post( url, { 
        "_": $.now(),
        "id": order_id
    });
    
    posting.done(function( answer ) { 
        console.log(answer);
        updateDOM(answer); // uaktualnij wygląd na stronie
    });
}

function updateDOM( prepaidInfo ) {
    
    var klasa;
    
    if( prepaidInfo.stan === null ) {
        klasa = 'null';
    } else {
        klasa = prepaidInfo.stan;
    }
    
    //usuń klasy decydujące o stanie (kolorze) i dodaj bierzącą
    $(theDD).removeClass("null confirmed money");
    $(theDD).addClass( klasa );
    
    if( prepaidInfo.clickable ) {
        $(theDD).addClass( "clickable" );
    } else {
        $(theDD).removeClass( "clickable" );
    }
    
}