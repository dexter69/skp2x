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
       setClases(this); // pozmieniaj klasy tak, by podświetlony był ten kliknięty
       setInput(this); // wpisz wartość klikniętego elementu do input 
    });
    
    /* Klikając na nazwę karty, generujemy pdf z etykietami */
    $(".label-summary .name").click(function(){
        // odczytaj dane dla etykiety i zwróć w formie obiektu
        var etykieta = getLabelData(this);        
        // wykreuj pdf
        makeLabPdf(etykieta);
    });
});

// odczytaj dane dla etykiety i zformatuj
function getLabelData( obj ) { // obj reprezentuje kliknięty element
    
    
    var label = { 
        job: '123/16',
        order: '254/16 MS',
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
        
        
        lang: 'pl',
        
            
        indec: 1
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
var pdfdata = [];
/* Wygeneruj kontent dla make pdf */
function kontent(etyk) {
    pdfdata = [];
    /* 
     * 1. Stwórz strukturę strony
     * 2. Oblicz liczbę stron i dane dla ostatniej 
     * 3. Pwiel strukturę tyle razy ile jest stron uzupełniając wartośći */
    
    // 1.
    //createStructure(etyk);
    
    // 2.
    if(etyk.baton !== 0 && etyk.licznik) {
        etyk.pages = Math.ceil(etyk.naklad/etyk.baton);
        if( etyk.suma ) { // drukujemy sume batonów, czyli np. /12
            etyk.sumb = "/" + etyk.pages;
        }
    } else {
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
    
    var baton = etyk.baton, labtxt = ' ', valtxt = ' ';
    if( etyk.baton === 0) {
        baton = " ";
    } else {
        if( etyk.left < etyk.baton ) {
            baton = etyk.left;
        }      
        if( etyk.licznik ) { // drukujemy licznik
            labtxt = 'opakowanie nr:';
            valtxt = etyk.lnr + etyk.sumb;
        }
    }
    
    pdfdata.push(                
        new page.firstLine(etyk.order, etyk.job),  
        new page.secondLine('produkt:', true),        
        new page.secondLine(etyk.name, false),
        new page.thirdLineV2(numberSeparator(etyk.naklad, " "), baton.toString()),
        new page.fourthLineV2(labtxt, true),
        new page.fourthLineV2(valtxt, false)
    );
    
}
