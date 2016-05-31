/* 
 *  Obsług przedpłaty po nowemu
 * 
 */

// obsługa otwierania i zamykania widżetu

var theSpan = ".ikony-handlowe > #the-dd-2"; //interesujący nas span z dolarami

$( document ).ready(function() {
   
    obslugaKlikniecia_wDolar();
});

// jak klikniemy w dolar, to chcemy otwierać/zamykać widżet i wiedzieć,
// która opcja (kolor) została wybrana
function obslugaKlikniecia_wDolar() {
    
    $(theSpan + " > i").click( function(){
        
        if( moznaKlikacWidzet() ) { // widżet działa tylko gdy jest clickable
            if( widzetJestOtwarty() ) { // znaczy klikniecie nastąpiło przy otwartym
                // czyli mamy albo zamknięcie, albo zmianę koloru dolara                
                if( klikDrugiLubTrzeci(this) ) { //zmiana koloru
                  var new_color = getNewColor(this);
                  console.log(new_color);
                  ustawNowyKolor(new_color);
                } 
                zamknijWidget(); // zamknij tak czy siak
            } else { // klikniecie nastąpiło przy zamkniętym - więc kwestia tylko otwarcia jest
                otworzWidget();
            }
        }
        
        
        
        
        
    });
}

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



/*  Funkcje typu tools
 */

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
