$( document ).ready(function() {
	
	$('.dlajoli').change(function() {
		
		var id = $(this).attr('idlike');
		
		if( $( this ).prop( "checked" ) )
			$('#' + id ).val(1);
		else
			$('#' + id ).val(0);
	});
	
	$('.dlajoli').each(function() {
		var id = $(this).attr('idlike');
		
		if( $( this ).prop( "checked" ) )
			$('#' + id ).val(1);
		else
			$('#' + id ).val(0);
	});

	/*
        Kod do obsługi edycji postów.    */

    // Po kliknięciu w to, otwieramy formularz
    $( "span.fixit" ).click(function() {
        // Włącz overlay
        overlay( true );
        // Na podstawie nr id zdarzenia, skonstruuj selektor div'a do edycji tego knkretnego postu               
        $("div.fix-div[data-evid='" + $(this).data( "evid" ) + "']").addClass( "edit" );
    });

    // Kliknięci w któryś z batonów formularza
    $( ".fix-div form button" ).click( function() {   
        let idPosta = $(this).data("evid");   
        if( $( this ).val() == 'save' ) {
            zapiszPosta( idPosta, $(this).data("znacznik") ); // przekazujemy id post'a i znacznik
        } else {
            anuluj(idPosta);
        }
    });

    // przyczep funkcjonalność chmurek do wszystkich selektorów li - kontrolek poprzedniej wersji
    setChmurki( ".wersja > :not(.toli)" );

});

/* Przyczep funkcjonalność chmurki do elemntów li w ul.wersja.
   Argument to selektor reprezentujący element/elementy, do których mają być przytwierdzone chmurki */
function setChmurki( zelektor ) {

    let theLis = $( zelektor ); // tu mamy wszystkie li pasujące do selektora

    let hoveredLI, chmurka;

    theLis.hover(
        // gdy mysza wchodzi na li
        function(){
            // cyferka spana w tym konkretnym li

            hoveredLI = this; // tu mamy konkretne li, to na które "wjechała myszka"

            // Cyferka zawarta w tym konkretnym li (a dokładnie w span'ie)
            let cyferka = $(hoveredLI).data("digit");            

            // Korespondująca z tym li chmurka do pokazania
            chmurka = $(hoveredLI).parent().parent().children(".ekstra-msgs").children(".old-msg.no-" + cyferka);
            
            // Pokaż ją!
            $(chmurka).addClass( "visible" );

        },
        // gdy mysza schodzi z li
        function(){
            // To schowaj chmurkę!
            $(chmurka).removeClass( "visible" );
            hoveredLI = null, chmurka = null;
        }
    );
    // 

}

function zapiszPosta( idPosta, znacznik ) {
        
    //włącz kręciołę
    krenciola( true );
    
    //sformatuj dane do wysłania
    let teDane = prepareData( idPosta, znacznik );

    //console.log("DANE DO ZAPISANIA"); console.log(teDane);
    
    //wyślij
    zapiszDoBazy( idPosta, teDane, function(result){
        console.log(result);
        if( result.success ) {
            // Zapisaliśmy z sukcesem
            

            /* Uaktualnij stronę */

            // post zdarzenia
            setPost(teDane.now, idPosta);
            // ukryty <p> all, ze wszystkimi wersjami
            setAll(teDane, idPosta);
            // uaktualnij dymki
            setDymki(teDane, idPosta);

            // wyłącz kręciołę i schowaj overaly
            krenciola( false );
            overlay(false);
        } else {
            // Coś poszło nie tak        
            servError()
        }
    });
        
}

// Uaktualnij dymki poprzednich wersji
function setDymki( dane, evid ) {

    let selektor = "div.postpost[data-evid='" + evid + "'] .wersja";    

    // Taki myk, że znamy numerek nowego dymka
    let nrek = $(selektor + " li").length;

    // Dodaj kontrolkę dymka
    let html = '<li data-digit="' + nrek + '"><span class="cyferka">' + nrek + '</span></li>';
    let toli = $(selektor + " .toli").before( html );

    let ourLi = toli.prev();
    // To jest nasz nowy span
    let theSpan = ourLi.children();

    // Teraz zawartość dymka
    // Nasz kontener msgs
    let selektor2 = "div.postpost[data-evid='" + evid + "'] p.ekstra-msgs";
    let html2 = '<span class="old-msg no-' + nrek + '">' + nl2br(dane.prev) + '</span>';
    $(selektor2).append(html2);

    // Jeszcze ustaw dla nowego obiektu, coby chmurka działała    
    setChmurki(ourLi);    

}

// Uaktualnij uryty el. p, tak by zawierał wszystkie wersje
function setAll( dane, evid ) {

    let selektor = ".fix-div[data-evid='" + evid + "'] > p.all";    
    // Ustaw nową wartość
    $(selektor).text(dane.znacznik + dane.now + dane.all);
}

// Uaktualnij posta w zdarzeniach do poprawionego
function setPost( nowy, evid ) {
    
    let selektor = "div.postpost[data-evid='" + evid + "'] ol li";
    let html = nl2br( nowy );
    
    $(selektor).html(html);
}

// Zamieniamy znak nowej linii na <br>
function nl2br( tekst ){
    return tekst.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
};

/**
 * @param {*} id - id event'u w bazie, który mamy nadpisać
 * @param {*} dane - body/post event'u który mamy zapisać
 * @param {*} after - callback - wywołujemy, po zakóczeniu komunikacji z serwerem */
function zapiszDoBazy( id, dane, after ) {

    console.log("DANE DO ZAPISANIA, in zapiszDo Bazy"); console.log(dane);
    // to zwracamy, gdy sukces
    let err = {
        success: false
    };

    // A to, gdy porażka
    let success = {
        success: true
    };

    let posting = $.post( "/events/evupdate.json", {
        "id": id,
        "post" : dane.znacznik + dane.now + dane.all
    });

    posting.done(function( answer ) { // sukces, dostaliśmy dane        
        console.log(answer);
        after(success);
    });

    posting.fail(function() { // błąd, coś poszło nie tak        
        if( posting.status === 403) { // traktujemy to, że użytkownik nie jest zalogowany
            // przekierowujemy do logowania
            location.assign('/users/login');
        } else { 
            console.log("BŁĄD PRZY MODYFIKACJI EVENTU");
        } //inny błąd
        after(err);
    });

}

function prepareData( idPosta, znacznik ) {

    // Wszystkie wartości posta do tej pory 
    let all = $(".fix-div[data-evid='" + idPosta + "'] > p.all").text();    
    
    //Bieżąca wartość wpisana w pole textarea
    let now = $(".fix-div[data-evid='" + idPosta + "'] form textarea").val();    

    //Wersja, którą poprawilismy
    let prev = all.split(znacznik)[1];

    /**
     * Nowy tekst doklejamy na początku i poprzedzamy go znacznikiem oznaczającym, że to multipost.
     * Znacznik jest ustalane przez backend i zapisywany jako atrybut data- w buttonie. Dostajemy go
     * jako argument wywołania tej funkcji.     */
    return {
        znacznik,
        now,
        prev,
        all
    }
}

function servError() {

    // - schowaj kręciłę i pokaż błąd
    let theObj = krenciola( false ); // tu mamy nasz .fix-div
    theObj.addClass("error");

    // Po kliknięciu w krzyżyk, zamknij error i schowaj overlay
    $(".fix-block .fix-div.error .errmsg p a").click(function(){
        theObj.removeClass("error");
        overlay(false);
    });
}

// Wł / wył kręciołę
function krenciola( On ) {

    let obj;
    if( On ) {
        obj = $(".fix-div.edit").removeClass("edit").addClass("sending");
        //console.log("IN KRĘĆIOŁA => ON");
    } else {
        obj = $(".fix-div.sending").removeClass("sending");
        //console.log("IN KRĘĆIOŁA => OFF");
    }
    return obj;
}



function anuluj( idPosta ) {
    
    // Usuń klasę "edit", coby nam później nie bruździła
    $(".fix-div.edit").removeClass( "edit" );
    // Schowaj overlay    
    overlay(false);
    // Aktualny, przed edycją post
    let selektor = ".fix-div[data-evid='" + idPosta + "'] > p.aktualny";
    //console.log(selektor);
    let aktualny = $(selektor).text();
    //console.log(aktualny);
    // "Zresetuj" formularz - jeżeli użytkownik coś wpisał, to chcemy mieć z powrotem to, co było
    $(".fix-div[data-evid='" + idPosta + "'] form textarea").val(aktualny); 
}

// Włącz/wyłącz overlay
function overlay( on ) {

    if( on ) { // włącz
        $( ".fix-block" ).width( "100%" );
    } else { //wyłącz
        $( ".fix-block" ).width(0);
    }
}

function toggleStatusEditablePossibility( obj ) {
	$( obj ).toggleClass( "on" );
}