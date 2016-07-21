/* 
 *  Obsług przedpłaty po nowemu
 * 
 */

// obsługa otwierania i zamykania widżetu

var theSpan = ".ikony-handlowe > #the-dd-2"; //interesujący nas span z dolarami
var base, url, url2, order_id;

$( document ).ready(function() {
    
    // dane do ajax
    base = $(theSpan).attr("base");
    url = base + "orders/prepaid.json";
    url2 = base + "orders/setPrePaidState.json";
    order_id = $(theSpan).attr("order_id");
   
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
        removeErrInfo(); // na wszelki wypadek
        getPeymentInfo(this, restOfDolarek);
    });
}

/*
 Sprawdzamy stan na serwerze i aktualizujemy DOM */
function checkPeymenCondition() {
   
    var posting = $.post( url, { "id": order_id } );
    
    posting.done(function( answer ) { // sukces, dostaliśmy dane        
        // uaktualnij stan faktyczny i wygląd na stronie
        var stringKlas = prepareClass(answer);
    
        $( theSpan ).removeClass( "null confirmed money red ora gre clickable" ); //czyścimy
        $( theSpan ).addClass( stringKlas ); // i nadajemy własciwe
        setDateZaliczkiOnDOM(answer);
    });
    
    posting.fail(function() { // błąd, coś poszło nie tak        
        if( posting.status === 403) { // traktujemy to, że użytkownik nie jest zalogowany
            // przekierowujemy do logowania
            location.assign(base + 'users/login');
        } else { console.log("FAIL-X"); printErr(4123);} //inny błąd
    });
}

// Sprawdzamy stan na serwerze, obj - technicznie, obiekt reprezentujący kliknięty dolarek
function getPeymentInfo(obj, cblFunction) {
    
    spinerON(); //Włącze kręciołe
    
    // Używamy POST, bo nie jest cach'owane
    var posting = $.post( url, { "id": order_id } );
    
    posting.done(function( answer ) { // sukces, dostaliśmy dane        
        // uaktualnij stan faktyczny i wygląd na stronie, a następnie przekaż obsługe 
        // do cblFunction
        uaktualnijDOM(answer, obj, cblFunction); 
    });
    
    posting.fail(function( /*answer*/ ) { // błąd, coś poszło nie tak        
        if( posting.status === 403) { // traktujemy to, że użytkownik nie jest zalogowany
            // przekierowujemy do logowania
            location.assign(base + 'users/login');
        } else { console.log("FAIL"); spinerOFF(); printErr(123);} //inny błąd
    });
}

// wydrukuj info o błędzie
function printErr(nr) {
    
    var html =
            '<p id="pay-err">Ooops..., coś poszło nie tak. Nr błędu: <b>'
            + nr + '</b><i class="fa fa-times" aria-hidden="true"></i></p>';
    
    $( ".ikony-handlowe" ).after( html );
    $("#pay-err").click( function(){        
        removeErrInfo();
    });
}

// Usuwa komunikat o błędzie
function removeErrInfo() {
    $( "#pay-err" ).remove();
}

// jak już się skomunikujemy z serwerem i uaktualnimy faktyczną sytuację
// to dopiero robimy resztę w temacie kliknięcia
function restOfDolarek(obj) {
    
    if( moznaKlikacWidzet() ) { // widżet działa tylko gdy jest clickable
        if( widzetJestOtwarty() ) { // znaczy klikniecie nastąpiło przy otwartym
            // czyli mamy albo zamknięcie, albo zmianę koloru dolara                
            if( klikDrugiLubTrzeci(obj) ) { //zmiana koloru i stanu przedpłaty              
              // zapisz na serwerze nowy stan i uaktualnij DOM
              setNewState(getNewColor(obj));
            } else {
                spinerOFF();
                zamknijWidget(); // zamknij, gdy tylko zamknięcie         
            }
        } else { // klikniecie nastąpiło przy zamkniętym - więc kwestia tylko otwarcia jest
            spinerOFF();
            otworzWidget();
        }
    } else { spinerOFF(); }
}
/*
 * Konwertujemy datę na bardziej miły format
 * @param {string} dateStr - zakłada, że string z datą jest w formacie typu:
 * 2016-07-09 (9 lip 2016)
 */
function konwertujDate( dateStr ) {
    
    var rok = dateStr.substr(0,4);
    var mie = dateStr.substr(5,2);
    var dzi = dateStr.substr(8,2);
    
    return dzi + " " + dataShort.miesiace[parseInt(mie)-1] + " " + rok;
}


function setDateZaliczkiOnDOM( answer ) {
    
    var datka;
    console.log("setDateZaliczkiOnDOM", answer);
    if( answer.stan_zaliczki === 'money' ) {
        datka = konwertujDate( answer.zaliczka_toa.substr(0,10) );
        $('#the-dd > span').text(datka); }
    else { 
        $('#the-dd > span').text(""); }
}

function setNewState(nowyKolorStr) {
    
    var nowyStan = kolor2Stan(nowyKolorStr);    
    var datka;
    
    // Uaktualnij na serwerze nowy stan
    var posting = $.post( url2, {         
        "id": order_id,
        "stan_zaliczki": nowyStan
    });
    
    posting.done(function( answer ) { // sukces, komunikacja udana        
        console.log("setNewState + done", answer);        
        if(answer.errno === 0) { // jeżeli nie ma błędu dane udało się zapisać
            ustawNowyKolor(nowyKolorStr);
            setDateZaliczkiOnDOM(answer);
        } else {
            console.log("errno = " + answer.errno);
            printErr("sNS + " + answer.errno);
        }
        spinerOFF();
        zamknijWidget(); // zamknij, tak czy siak        
    });
    
    posting.fail(function() { // błąd, coś poszło nie tak        
        if( posting.status === 403) { // traktujemy to, że użytkownik nie jest zalogowany
            // przekierowujemy do logowania
            location.assign(base + 'users/login');
        } else { 
            console.log("FAIL - setNewState");
            spinerOFF();
            zamknijWidget();
            printErr("321 + " + posting.status); } //inny błąd
    });
        
}

/* Uaktualnij DOM 
 * @param {object} info - obiet zwrócony z serwera z danymi o przedpłacie
 * @param {object} dolar - nasz kliknięty dolarek
 * @param {object} mojKolbek - funkcja do wywołania, która zajmuje się obsługą dolarków
 * @returns {undefined}
 */
function uaktualnijDOM(info, dolar, mojKolbek) {
    
    var stringKlas = prepareClass(info);
    
    console.log("uaktualnijDOM", info);
    //console.log(stringKlas);
    $( theSpan ).removeClass( "null confirmed money red ora gre clickable" ); //czyścimy
    $( theSpan ).addClass( stringKlas ); // i nadajemy własciwe
    setDateZaliczkiOnDOM(info);
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

/*
 * Konweryjemy kolor dolarka na wartość do zapisania w bazie
 * @param {string} str
 * @returns {String or null}
 */
function kolor2Stan(str) {
  
    switch( str ) { 
        case 'red': return 'red';
        case 'ora': return 'confirmed';
        case 'gre': return 'money';
    }
}

// na czas komunikacji z serwerem włączamy kręciołe
function spinerON() { $( theSpan ).addClass( "waiting" ); }
// po otrzymaniu odpowiedzi wyłączamy
function spinerOFF() { $( theSpan ).removeClass( "waiting" ); }


/*  Funkcje typu tools
 */

// zmienia kolor theSpan na "nowy"
function ustawNowyKolor( nowy ) {
    console.log(nowy);
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
