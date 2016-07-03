/* 
 *  Obsług przedpłaty po nowemu
 * 
 */
/* Tymczasowy sobie test */
// obsługa otwierania i zamykania widżetu

var theSpan = ".ikony-handlowe > #the-dd-2"; //interesujący nas span z dolarami

$( document ).ready(function() {
   
   klikanieDolarka();       // zamontuj obsługę klikania w dolar
   checkPeymenCondition();  // sprawdź aktualny stan i uaktualnij DOM
                            // ważne w razie ładowania strony z cacha
});

// jak klikniemy w dolar, to chcemy otwierać/zamykać widżet i wiedzieć,
// która opcja (kolor) została wybrana
function klikanieDolarka() {
    
    $(theSpan + " > i.fa-usd").click( function(){
        
        // sprawdz aktualny stan na serwerze, po otrzymaniu danych, uaktualnij i działaj dalej
        var payObj = getPeymentInfo(this, restOfDolarek);
        
    });
}

// jak już się skomunikujemy z serwerem i uaktualnimy faktyczną sytuację
// to dopiero robimy resztę w temacie kliknięcia
function restOfDolarek(obj) {
    
    if( moznaKlikacWidzet() ) { // widżet działa tylko gdy jest clickable
        if( widzetJestOtwarty() ) { // znaczy klikniecie nastąpiło przy otwartym
            // czyli mamy albo zamknięcie, albo zmianę koloru dolara                
            if( klikDrugiLubTrzeci(obj) ) { //zmiana koloru
              var new_color = getNewColor(obj);
              console.log(new_color);
              ustawNowyKolor(new_color);
            } 
            zamknijWidget(); // zamknij tak czy siak
        } else { // klikniecie nastąpiło przy zamkniętym - więc kwestia tylko otwarcia jest
            otworzWidget();
        }
    } 
}

// Sprawdzamy stan na serwerze
function getPeymentInfo(obj, cblFunction) {
    
    var url = $(theSpan).attr("base") + "orders/prepaid.json";
    var order_id = $(theSpan).attr("order_id");
    
    spinerON(); //Włącze kręciołe
    
    // Używamy POST, bo nie jest cach'owane
    var posting = $.post( url, { 
        "_": $.now(),
        "id": order_id
    });
    
    posting.done(function( answer ) { 
        console.log(answer);
        //updateDOM(answer); // uaktualnij wygląd na stronie
    });
    
    posting.always(function( answer ) { 
        spinerOFF(); // wyłącz kręciołę
        cblFunction(obj);
    });
    
    return {};
}

// na czas komunikacji z serwerem włączamy kręciołe
function spinerON() { $( theSpan ).addClass( "waiting" ); }
// po otrzymaniu odpowiedzi wyłączamy
function spinerOFF() { $( theSpan ).removeClass( "waiting" ); }

/*
 Sprawdzamy stan na serwerze i aktualizujemy DOM */
function checkPeymenCondition() {
    
}



/*  Funkcje typu tools
 */

// zmienia kolor theSpan na "nowy"
function ustawNowyKolor( nowy ) {
    
    $( theSpan ).removeClass( "red ora gre" );
    $( theSpan ).addClass( nowy );
}

// Sprawdz na jaki kolor trzeba zmienić. obj reprezentuje obiekt kliknietego elementu
function getNewColor(obj) {
    
    switch( obecnyKolor() ) {
        case 'red':
            if( $(obj).attr('dolar') === 'two' ) { return 'ora'; } //kliknieto na drugi
            return 'gre'; // kliknieto na trzeci
        case 'ora':
            if( $(obj).attr('dolar') === 'two' ) { return 'gre'; }
            return 'red';
        case 'gre':
            if( $(obj).attr('dolar') === 'two' ) { return 'red'; }
            return 'ora';
    }
}

//zwraca obecny kolor widgetu
function obecnyKolor() {
    
    if( $(theSpan).hasClass('red') ) { return 'red'; }
    if( $(theSpan).hasClass('ora') ) { return 'ora'; }
    return 'gre';
}





// sprawdza, czy klikniecie bylo w 2-gi lub 3-i. Obj - obiekt reprezentujący klikniety elem.
function klikDrugiLubTrzeci(obj) {
    
    return ( $(obj).attr('dolar') !== 'one' );
}

//jak sama nazwa wskazuje
function otworzWidget() { $(theSpan).addClass('open'); }
function zamknijWidget() { $(theSpan).removeClass('open'); }

// zwraca prawde, gdy mozna
function moznaKlikacWidzet()  { 
    // widżet działa tylko gdy jest clickable
    return $(theSpan).hasClass('clickable');
}

// zwraca prawdę, gdy widzet jest otwarty
function widzetJestOtwarty() {  return $(theSpan).hasClass('open'); }
