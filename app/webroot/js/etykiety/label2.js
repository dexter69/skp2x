$( document ).ready(function() {
    // wyczyść input przy załadowaniu i uczyń katywnym
    $('#TaskNumer').val(""); $('#TaskNumer').focus();
    
    // w razie kliknięcia na ten input, wyczyść go
    $('#TaskNumer').click(function(){ // przy kliknięciu wyzeruj ten input
        $(this).val("");
    });    
    
    // W razie odświeżenia strony chcemy skorygować zawartość pola input
    // ustaw we wszystkich kartach prawidłowe wartości pola input
    setProperInput();
    
    //Kliknięcie w dowolny "klikacz" powoduje zmianę we wszystkich jego braciach
    $('.label-summary li').click(function(){
       // niebyc - oznacza, że dla tej karty nie drukujemy etykiet
       // plik - że jest gotowy plik etykiet
       var theDiv = $(this).parent().parent();
       if( !$(theDiv).hasClass('niebyc') && !$(theDiv).hasClass('plik') ) {
            setClases(this); // pozmieniaj klasy tak, by podświetlony był ten kliknięty
            setInput(this); // wpisz wartość klikniętego elementu do input 
       }
    });
    
    /* Klikając na nazwę karty, generujemy pdf z etykietami */
    $(".label-summary .name").click(function(){
        // niebyc - oznacza, że dla tej karty nie drukujemy etykiet
        // plik - że jest gotowy plik etykiet
        var theDiv = $(this).parent();
        if( !$(theDiv).hasClass('niebyc') &&
            !$(theDiv).hasClass('plik') ||
            $(theDiv).hasClass('zbiorcza') ) { // na zbiorcze zawsze da się wydrukować        
                makeLabPdf( // wykreuj pdf
                    getLabelData(this) // odczytaj dane dla etykiety i zwróć w formie obiektu
            );    
        }        
    });

    /* Klikając przycisk przełaczmy się między generacją dla batona a dla zbiorczego */
    $(".infobar .switch button").click(function(){
        //console.log('zbiorczoza !');
        przelanczKlasy(this); //wszelkie machlojki z klasami robi
        //console.log($(this).text());
    });

});

function przelanczKlasy(obj) {

    var bar = {        
        baton: "baton", //klasa dla widoku batona
        zbiorcza: "zbiorcza" //klasa dla etykiety zbiorczej        
    },
    przycisk = {
        baton: "btn-primary",
        zbiorcza: "btn-success"
    },
    pradziadek = $( obj ).parent().parent(),
    theUl = $( obj ).parent().parent().next(), // nasze ul przyciskami ilości
    praPraDziadek = $( obj ).parent().parent().parent(); // wraping div

    if( $( pradziadek ).hasClass(bar.baton) ) { // przełącz na zbiorcze
        $( pradziadek ).removeClass( bar.baton );
        $( pradziadek ).addClass( bar.zbiorcza );
        $( praPraDziadek ).addClass( bar.zbiorcza );
        $(obj).text(bar.zbiorcza);
        $(obj).removeClass(przycisk.baton);
        $(obj).addClass(przycisk.zbiorcza);        
    } else { // przełącz na batony
        $( pradziadek ).removeClass( bar.zbiorcza );
        $( pradziadek ).addClass( bar.baton );
        $( praPraDziadek ).removeClass( bar.zbiorcza );
        $(obj).html("&nbsp;&nbsp;" + bar.baton + "&nbsp;&nbsp;");
        $(obj).removeClass(przycisk.zbiorcza);
        $(obj).addClass(przycisk.baton);        
    }
    replaceValues(theUl);
}

// przełączamy wartości batonów
function replaceValues( naszeUL ) {

    var
        obj = $(naszeUL).children(':not(.input)'),
        to = $(naszeUL).find("." + $(naszeUL).attr('act') ),
        vtekst;
    
    $(obj).each(function(){
        
        var stored = $(this).data('q'),
            tekst = $(this).text();
        // podmień wartości
        $(this).text(stored);
        $(this).data('q', tekst);
    });

    // aktualizujemy input     
    if( to.length ) { // tzn znaleźliśmy
        vtekst = $(to).text();        
    } else { // bierzemy perwszy element li
        vtekst = $(obj).first().text();        
    }
    // nadaj wartosc
    $(naszeUL).find('input').val(vtekst);
}

// odczytaj dane dla etykiety i zformatuj
function getLabelData( obj ) { // obj reprezentuje kliknięty element
    /* Dane językowe do etykiet */
    var langoza = {
        produkt:    {'pl': 'produkt:', 'en': 'product:', 'de': 'Produkt'},  
        naklad:     {'pl': 'zamówiona ilość:', 'en': 'ordered quantity:', 'de': 'Bestellmenge'},
        wbatonie:   {'pl': 'ilość w opakowaniu:', 'en': 'batch:', 'de': 'Inhalt'},
        onr:        {'pl': 'opakowanie nr:', 'en': 'batch no.:', 'de': 'Karton'},
        short:      { // wersje krótkie, gdy ciasno
            produkt:    {'pl': 'produkt:', 'en': 'product:', 'de': 'Produkt'},  
            naklad:     {'pl': 'zamówione:', 'en': 'ordered qty:', 'de': 'Bestellmenge'},
            wbatonie:   {'pl': 'w opakowaniu:', 'en': 'batch:', 'de': 'Inhalt'},
            onr:        {'pl': 'opakowanie nr:', 'en': 'batch no.:', 'de': 'Karton'},
        }
    },
    
    label = { 
        job: $(obj).data('produkcyjne'),
        order: $(obj).data('handlowe'),
        name: $(obj).data('product'),
        naklad: parseInt($(obj).data('naklad')),
        baton: $($(obj).parent().find("input")).val(),
        // czy etykieta ma byc zbiorcza
        zbiorcza: $(obj).parent().hasClass('zbiorcza'),

        inbox: true, /* czy generujemy ilość w kart w batonie.
        False oznacza puste (miejsce na ręczny wpis) -> pociąga to równieżź za sobą fakt,
        że boxnr będzie false */
        licznik: true, /* numerowanie batonów, czyli 1, 2, 3.... */
        suma: true, /* sumowanie batonów - będzie (np.) 1/12, 2/12, ..., 12/12 */
        sumb: '',
        lnr: 1, // nr strony/batona, zaczynamy od 1,           
        /* Słowa zależne od języka na etykiecie */
        labels: {
            produkt: langoza.produkt[$(obj).data('lang')],
            naklad: langoza.naklad[$(obj).data('lang')],
            wbatonie: langoza.wbatonie[$(obj).data('lang')],
            onr: langoza.onr[$(obj).data('lang')]
        },
        zakres: rangeService(obj, {
                produkt: langoza.short.produkt[$(obj).data('lang')],
                naklad: langoza.short.naklad[$(obj).data('lang')],
                wbatonie: langoza.short.wbatonie[$(obj).data('lang')],
                onr: langoza.short.onr[$(obj).data('lang')]
        })     
    };
    
    if( label.baton === "" || label.baton === null ) {
        /* Pole ilości w formularzu puste, sprawdzanie null na wszelki wypadek.
         * Znaczy, że użytkownik nie chce drukować ilości w batonie,
         * więc nie liczymy również sumy batonów, będzie tylko 1 etykieta */        
        label.baton = 0;
        label.inbox = false;
    } else {
        label.baton = parseInt(label.baton);
        label.left = label.naklad;
    }
    
    return label;
}

// W wypadku etykiet z zakresami ta funkcja robi obsługę tego
function rangeService( obj, shortlabels ) { // obj reprezentuje H3 w DOM

    var zakres = {
        form_exists: false,
        prefix: null,
        start: null,
        suffix: null,
        labels: shortlabels
    };

    var form = $(obj).parent().find("form");
    
    if( form.length ) {        
        zakres.prefix = $(form).find("#prefix").val();
        zakres.start = $(form).find("#start").val();
        zakres.suffix = $(form).find("#suffix").val();
        zakres.form_exists = !!zakres.start && /^[0-9]+$/.test(zakres.start);// niepuste i składa się z wyłącznie cyfr        
    }
    return zakres;
}

// generujemy etykietę z danych umieszczonych w label
function makeLabPdf( label ) {
    
    var maxdl = 52; // maksymalna długość nazwy produktu (przy czcionce 11)
    // obcinamy, gdy za długie, nie chcemy by wyszło nam na 3 linijki
    label.name = label.name.substr(0,maxdl); 

    docDefinition.content = kontent(label);    

    // open the PDF in a new window
    pdfMake.createPdf(docDefinition).open();
}

// tu wdzingujemy strukturę pdf'a
var pdfdata = [];


function kontent(etyk) {
    
    pdfdata = [];    
    etyk = kontentPart1(etyk);
    console.log(etyk);
    do {
      addStructureOfOnePage(etyk);      
      etyk.pages--;  
      etyk.lnr++; // kolejny nr batona     
      etyk.left -= etyk.baton;
    } while( etyk.pages > 0);
    
    delete pdfdata[pdfdata.length-1].pageBreak;  //nie chcemy by na generował break po ostatniej stronie
    return pdfdata;
}

// Czysto dla skrócenia kodu
function kontentPart1(etyk) {

    etyk.labtxt = etyk.valtxt = ' ';
    
    if( etyk.baton !== 0 ) {
        etyk.baton2 = etyk.baton;
        if( etyk.licznik ) { // drukujemy licznik
            etyk.pages = Math.ceil(etyk.naklad/etyk.baton);
            etyk.labtxt = 'opakowanie nr:';
            if( etyk.suma ) { // drukujemy sume batonów, czyli np. /12
                etyk.sumb = "/" + etyk.pages;
            }
            if( etyk.zakres.form_exists ) { // jeżeli etykiety z zakrsem to odpowiednie dane
                etyk.zakres.od = Number(etyk.zakres.start);
                etyk.zakres.length = etyk.zakres.start.length;
            }
        } else {
            etyk.pages = 1;
        }
    } else {
       etyk.baton2 = " "; 
       etyk.pages = 1;
    }

    return etyk;
}

function addStructureOfOnePage(etyk) {
    
    if( etyk.baton !== 0) {
        if( etyk.left < etyk.baton ) {
            etyk.baton2 = etyk.left;
        }      
        if( etyk.licznik ) { // drukujemy licznik            
            etyk.valtxt = etyk.lnr + etyk.sumb;
        }
    } else {
        etyk.labels.onr = ""; // nie chcemy tego, gdy wpisywanie ręczne
    }
    
    if( etyk.zakres.form_exists ) {
        constructPageWithZakres(etyk); // wersja z zakresem        
    } else {
        constructPage(etyk);
    }        
}

// przygotuj strukturę strony dokumentu - nowa wrsja pod etykietę z zakresami 2018-02-12
function constructPageWithZakres(etyk) {

    //console.log("We are here!");
    if( etyk.zbiorcza )   { //ma być etykieta na zbiorcze        
        prepareZbiorcza(etyk);
    } else {
        prepareBatonZakres(etyk);      // etykieta dla batona z zakesem  
        etyk.zakres.od += etyk.baton;        
    }
}

// przygotuj strukturę strony dokumentu
function constructPage(etyk) {

    if( etyk.zbiorcza )   { //ma być etykieta na zbiorcze        
        prepareZbiorcza(etyk);
    } else {
        prepareBaton(etyk);        
    }
}

function prepareZbiorcza(etyk) {

    pdfdata.push(                
        new pagez.firstLine(etyk.name),  
        new pagez.secondLine(numberSeparator(etyk.naklad, " "), etyk.baton2.toString(), etyk.labels),            
        new pagez.thirdLine(etyk.labels.onr, true),
        new pagez.thirdLine(etyk.valtxt, false),
        new pagez.fourthLine(etyk.job)            
    );
}

function prepareBaton(etyk) {

    pdfdata.push(                
        new page.firstLine(etyk.order, etyk.job),  
        new page.secondLine(etyk.labels.produkt, true),        
        new page.secondLine(etyk.name, false),
        new page.thirdLineV2(numberSeparator(etyk.naklad, " "), etyk.baton2.toString(), etyk.labels),
        new page.fourthLineV2(etyk.labels.onr, true),
        new page.fourthLineV2(etyk.valtxt, false)
    );
}

function prepareBatonZakres(etyk) {

    //console.log("prepareBatonZakres");
    pdfdata.push(                
        new pageRange.firstLine(etyk.order, etyk.job),  
        
        new pageRange.secondLine(etyk.name, false),

        new pageRange.secondLine(" ", true),        // odstęp

        new pageRange.thirdLine(numberSeparator(etyk.naklad, " "), etyk.baton2.toString(), etyk),

        new pageRange.secondLine(" ", true),        // odstęp
        
        new pageRange.fourthLine(etyk, true ), 
        new pageRange.fourthLine(etyk, false ) 
    );
}