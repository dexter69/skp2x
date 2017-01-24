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
        if( !$(theDiv).hasClass('niebyc') && !$(theDiv).hasClass('plik') ) {
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
        selektor: ".infobar", //klasa belki
        baton: "baton", //klasa dla widoku batona
        zbiorcza: "zbiorcza", //klasa dla etykiety zbiorczej
        obie: function() {return this.baton + ' ' + this.zbiorcza;}
    },
    przycisk = {
        baton: "btn-primary",
        zbiorcza: "btn-success"
    };

    //console.log(bar.obie());
    // przełączamy klasę dziadka przycisku, czyli belkę (bar)
    if( $( bar.selektor ).hasClass(bar.baton) ) {
        $( bar.selektor ).removeClass( bar.baton );
        $( bar.selektor ).addClass( bar.zbiorcza );
        $(obj).text(bar.zbiorcza);
        $(obj).removeClass(przycisk.baton);
        $(obj).addClass(przycisk.zbiorcza);
    } else {
        $( bar.selektor ).removeClass( bar.zbiorcza );
        $( bar.selektor ).addClass( bar.baton );
        $(obj).html("&nbsp;&nbsp;" + bar.baton + "&nbsp;&nbsp;");
        $(obj).removeClass(przycisk.zbiorcza);
        $(obj).addClass(przycisk.baton);
    }

}

// odczytaj dane dla etykiety i zformatuj
function getLabelData( obj ) { // obj reprezentuje kliknięty element
    /* Dane językowe do etykiet */
    var langoza = {
        produkt:    {'pl': 'produkt:', 'en': 'product:'},  
        naklad:     {'pl': 'zamówiona ilość:', 'en': 'ordered quantity:'},
        wbatonie:   {'pl': 'ilość w opakowaniu:', 'en': 'batch:'},
        onr:        {'pl': 'opakowanie nr:', 'en': 'batch no.:'}  
    },
    
    label = { 
        job: $(obj).data('produkcyjne'),
        order: $(obj).data('handlowe'),
        name: $(obj).data('product'),
        naklad: parseInt($(obj).data('naklad')),
        baton: $($(obj).parent().find("input")).val(),
        
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
        }
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

/* Wygeneruj kontent dla make pdf */
function kontent(etyk) {
    pdfdata = [];        
    etyk.labtxt = etyk.valtxt = ' ';
    
    if( etyk.baton !== 0 ) {
        etyk.baton2 = etyk.baton;
        if( etyk.licznik ) { // drukujemy licznik
            etyk.pages = Math.ceil(etyk.naklad/etyk.baton);
            etyk.labtxt = 'opakowanie nr:';
            if( etyk.suma ) { // drukujemy sume batonów, czyli np. /12
                etyk.sumb = "/" + etyk.pages;
            }
        } else {
            etyk.pages = 1;
        }
    } else {
       etyk.baton2 = " "; 
       etyk.pages = 1;
    }
    
    do {
      addStructureOfOnePage(etyk);      
      etyk.pages--;  
      etyk.lnr++; // kolejny nr batona     
      etyk.left -= etyk.baton;
    } while( etyk.pages > 0);
    
    delete pdfdata[pdfdata.length-1].pageBreak;  //nie chcemy by na generował break po ostatniej stronie
    return pdfdata;
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
        etyk.labels.onr = ""; // nie chcemy tego, gdy w[isywanie ręczne
    }
    
    pdfdata.push(                
        new page.firstLine(etyk.order, etyk.job),  
        new page.secondLine(etyk.labels.produkt, true),        
        new page.secondLine(etyk.name, false),
        new page.thirdLineV2(numberSeparator(etyk.naklad, " "), etyk.baton2.toString(), etyk.labels),
        new page.fourthLineV2(etyk.labels.onr, true),
        new page.fourthLineV2(etyk.valtxt, false)
    );
    
}
