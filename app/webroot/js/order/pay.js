/* 
 *  Obsług przedpłaty po nowemu
 * 
 */

// obsługa otwierania i zamykania widżetu

var theSpan = ".ikony-handlowe > #the-dd-2"; //interesujący nas span z dolarami

$( document ).ready(function() {
   
   klikanieDolarka();       // zamontuj obsługę klikania w dolar
   checkPeymenCondition();  // sprawdź aktualny stan i uaktualnij DOM
                            // ważne w razie ładowania strony z cacha
});

// jak klikniemy w dolar, to chcemy otwierać/zamykać widżet i wiedzieć,
// która opcja (kolor) została wybrana
// rejestrujemy klinknięciw w pojedynczego dolarka ( theSpan + " > i.fa-usd" )
function klikanieDolarka() {
    
    $(theSpan + " > i.fa-usd").click( function(){        
        // sprawdz aktualny stan na serwerze, po otrzymaniu danych,
        // uaktualnij i działaj dalej
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

// Sprawdzamy stan na serwerze, obj - technicznie, obiekt reprezentujący kliknięty dolarek
function getPeymentInfo(obj, cblFunction) {
    
    var base = $(theSpan).attr("base");
    var url = base + "orders/prepaid.json";
    var order_id = $(theSpan).attr("order_id");
    
    spinerON(); //Włącze kręciołe
    
    // Używamy POST, bo nie jest cach'owane
    var posting = $.post( url, { 
        "_": $.now(),
        "id": order_id
    });
    
    posting.done(function( answer ) { // sukces, dostaliśmy dane        
        // uaktualnij stan faktyczny i wygląd na stronie, a następnie przekaż obsługe 
        // do cblFunction
        updateDOM(answer, obj, cblFunction); 
    });
    
    posting.fail(function( answer ) { // błąd, coś poszło nie tak        
        if( posting.status === 403) { // traktujemy to, że użytkownik nie jest zalogowany
            // przekierowujemy do logowania
            location.assign(base + 'users/login');
        } else { console.log("FAIL"); }
    });
    
    posting.always(function( answer ) { // kod wykonywany zawsze
        spinerOFF(); // wyłącz kręciołę
        //cblFunction(obj);
    });
    
    return {};
}

/*
 * info - obiekt otrzymany z serwera z aktualnym stanem
 * obj  - technicznie, obiekt reprezentujący kliknięty dolarek
 * funkcjaKolbek - funkcja do wywołania, po aktualizacji DOM'a
 */
function updateDOM(info, obj, funkcjaKolbek) {
    // Tu uaktualniamy stan strony do serwera
    
    console.log(info);
    var klasa_ext = prepareClass(info);
    console.log(klasa_ext);
    uaktualnijDOM(klasa_ext, obj, funkcjaKolbek);
    
}
/* Uaktualnij DOM 
 * @param {string} stringKlas - obliczone klasy do naszego span'a
 * @param {object} dolar - nasz kliknięty dolarek
 * @param {object} mojKolbek - funkcja do wywołania, która zajmuje się obsługą dolarków
 * @returns {undefined}
 */
function uaktualnijDOM(stringKlas, dolar, mojKolbek) {
    
    $( theSpan ).removeClass( "null confirmed money red ora gre clickable" );
    $( theSpan ).addClass( stringKlas );
    mojKolbek(dolar);
}

/* Przygotuj wartości klass dla theSpan
 * @param {object} infoObj
 * @returns {String}
 */
function prepareClass(infoObj) { 
  
    var klasa_ext;
    
    if( infoObj.jest_zaliczka ) { // zamówienie z zaliczką
        switch( infoObj.stan_zaliczki ) {
            case null: klasa_ext = 'null red'; break; // brak jakiegokolwiek wpisu
            case 'confirmed': klasa_ext = 'confirmed ora'; break; // potwierdzona wpłata
            case 'money': klasa_ext = 'money gre'; break; // są pieniądze na koncie
        }
        if( infoObj.clickable ) { klasa_ext += ' clickable'; }
    } else { // bez zaliczki - z defincji płatność uregulowana
        klasa_ext = 'null gre'; // zielone
    }
    return klasa_ext;
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
