var tenSelektor = '#proof-preview';
$(function() {
    /*
    $( "#kwi" ).click(function(){
        var tmp = $(this).data("lan");
        var text = $(this).text();
        $(this).text(tmp);
        $(this).data("lan", text);
    });
    
    $( "#burok" ).keyup(function() {
        console.log( "Handler for .keyup() called." );
    });
    */
    //console.log(model);
    //log('start');
    refreshProofData( setEditableOrNot );    
    setKlik4Klodka();
  });

/* zasysnij swieze dane i gdy sukces, to wywołaj callback function */
function refreshProofData( callBack ) {
    
    /* myBase to zmienna generowana w nagłówku przez $this->webroot 
     pieprzony get robi cache i jak strona się ładuje z cacha, to skurczybyk
     się z serwerem nie kontaktuje i dlatego ten parametr potrzebny */
    var geting = $.get( myBase + "cards/editable.json", { "_": $.now() } );
    
    geting.done(function( dane ) {   
        callBack( dane ); // w zależności od stanu ustawiamy możliwość edycji lub jej brak        
    });
}

function setEditableOrNot( info ) {
    /* info to dane zasysnięte z serwera o stałej strukturze */
    if( info.editable ) {   
        setEdycjaDozwolona();        
    } else {
        setEdycjaZabroniona();
    } 
}

function setKlik4Klodka() {
    
    $("#panel > i").click(function(){        
        //console.log(stanKlodki());
        refreshProofData( klikService );
    });
}

// po kliknięciu w kłudkę i odświerzeniu danych Proof'a robimy obsługę tego kliknięcia
function klikService( info ) {
    // info to dane zasysnięte z serwera o stałej strukturze 
    switch( stanKlodki() ) { // stan klodki na stronie, NIE na serwerze!
        case 'czerwona':  // zamknięta i czerwona
            if( info.editable ) {
                // zmień kłudkę na zieloną
                setEdycjaDozwolona(); 
            }
            break;
        case 'zamknieta': // zamknięta i zielona
            if( info.editable ) {
                // otwórz kłudkę
                swapLock2();
            } else {
                // zrób czerwoną
                setEdycjaZabroniona(); }
            break; 
        case 'otwarta': // otwarta i zielona
            if( info.editable ) {
                // zapisz dane i zamknij kłudkę
                swapLock();
            } else {
                // zrób czerwoną i komunikat o niemożności zapisania
                swapLock();
                setEdycjaZabroniona();
                console.log('Edycja nie jest dozwolona, nie zapisano danych!');
            }
            break;
        default: // inny przypadek, czyli błąd! - wyświetl komunikat
            console.log('pieprzony blad!');
    }
}

function swapLock() {
    $('#proof-preview').toggleClass('locked');
    $('#proof-preview').toggleClass('unlocked');
}

function setEdycjaDozwolona() {    
    zamienKlasy(tenSelektor, 'edit-no', 'edit-yes');
}

function setEdycjaZabroniona() {    
    zamienKlasy(tenSelektor, 'edit-yes', 'edit-no');
    zamienKlasy(tenSelektor, 'unlocked', 'locked');
}


function stanKlodki() {
    
    if( $(tenSelektor).hasClass('edit-yes') ) {
        if( $(tenSelektor).hasClass('locked') ) {
            return 'zamknieta';
        }
        if( $(tenSelektor).hasClass('unlocked') ) {
            return 'otwarta';
        }
        return 'error'; // coś nie tak...
    }
    if( $(tenSelektor).hasClass('edit-no') ) {
        if( $(tenSelektor).hasClass('locked') ) {
            return 'czerwona';
        }
        return 'error'; // coś nie tak...
    }
    return 'error'; // coś nie tak... 
}

function zamienKlasy(selektor, skasuj, dodaj) {
/* selektor - selektor elementu,  skasuj - klasa, którą należy wyrzucić
 * dodaj - klasa, którą należy dodać  */    
    $(selektor).removeClass(skasuj);
    $(selektor).addClass(dodaj);
}

function log( str ) {
    
    var d = new Date();
    console.log(d.toLocaleTimeString());
    console.log(str);
}

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> DEPREC
function setUpThePadlock_old() {
    
    /* myBase to zmienna generowana w nagłówku przez $this->webroot 
     pieprzony get robi cache i jak strona się ładuje z cacha, to skurczybyk
     się z serwerem nie kontaktuje i dlatego ten parametr potrzebny */
    var geting = $.get( myBase + "cards/editable.json", { "_": $.now() } );
    
    geting.done(function( dane ) {        
        //log(dane.editable);
        //console.log(dane);
        setEditableOrNot(dane.editable); // w zależności od stanu ustawiamy możliwość edycji lub jej brak        
    });
    setKlik4Klodka();
}

function setUpThePadlock() {
    
    refreshProofData( setEditableOrNot );    
    setKlik4Klodka();
}

//################################################


function setThePadlockGreen() {
    
    console.log("Powinna być zielona MUU");
    setProofEditable();
    bindKlickServis4klodka(); //coby się otwierała i zamykała
}

function bindKlickServis4klodka() {
    
    //console.log('SET');
    $(".edit-yes #panel > i").click(function(){        
        //swapLock(); // otwórz lub zamknij kłudkę
    });
}

function swapLock_old() {
    $('#proof-preview').toggleClass('locked');
    $('#proof-preview').toggleClass('unlocked');
    $('#proof-preview #panel > i').toggleClass('fa-lock');
    $('#proof-preview #panel > i').toggleClass('fa-unlock');
}

function setProofEditable() {
    $('#proof-preview').removeClass('edit-no');
    $('#proof-preview').addClass('edit-yes');
}

function setThePadlockRed() {
    console.log("Niechaj będzie czerwona KWE");
    setProofUnEditable();
}

function setProofUnEditable() {
    $('#proof-preview').removeClass('edit-yes');
    $('#proof-preview').addClass('edit-no');
}

// ustaw kłodkę do klikania
function setupKlodka() {
    
   
    $("[data-editable=true] i").click(function(){
        
        console.log('Zakwakal !!');
    });
}


