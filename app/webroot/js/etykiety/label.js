$( document ).ready(function() {
    // wyczyść input przy załadowaniu i uczyń katywnym
    $('#TaskNumer').val(""); $('#TaskNumer').focus();
    
    // w razie kliknięcia na ten input, wyczyść go
    $('#TaskNumer').click(function(){ // przy kliknięciu wyzeruj ten input
        $(this).val("");
    });    
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

// LEVEL 01 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

// odczytaj dane dla etykiety i zformatuj
function getLabelData( obj ) { // obj reprezentuje kliknięty element
    
    var name = $(obj).data('product'),
        naklad = 2000,
        batons = '/4'; //ile wszystkich batonów
    
    return {
      job: '123/16',
      order: '254/16 MS',
      name: name,//'Nazwa karty',
      //name: $(obj).text(),
      naklad: naklad,
      baton: '500',
      batons: batons,
      left: naklad, // techniczna, pomocna przy generacji
      lnr: 4, // nr strony/batona, zaczynamy od 1,
      indec: -1 // o ile zwiększamy/zmniejszamy nr
    };
}

// generujemy etykietę z danych umieszczonych w label
function makeLabPdf( label ) {
    
    var maxdl = 52; // maksymalna długość nazwy produktu (przy czcionce 11)
    // obcinamy, gdy za długie, nie chcemy by wyszło nam na 3 linijki
    label.name = label.name.substr(0,maxdl);
    
    var nr = label.job + ' [' + label.order + ']';
    
    docDefinition.content = kontent(label);       
    // open the PDF in a new window
    pdfMake.createPdf(docDefinition).open();
}

// klikniety - obj reprezentujący klikniety element
function setClases( klikniety ) {
    // pobierz wartość klasy aktywnej i zwykłej
    var actClass = $( klikniety ).attr("act");
    var norClass = $( klikniety ).attr("nor");
    //znajdzć wszystkie li elementy tej listy
    var brothers = $($( klikniety ).parent()).children();
    // i dezaktuwuj ewentualne aktywne elementy
    $( brothers ).removeClass(actClass);
    // Znormalizuj
    $( brothers ).addClass(norClass);
    // Nadaj klikniętemu klasę aktywną
    $( klikniety ).removeClass(norClass);
    $( klikniety ).addClass(actClass);
}

/* klikniety - obj reprezentujący klikniety element. Pobierz jego wartość i wpisz
 * do input */
function setInput( klikniety ) {
    var ul = $( klikniety ).parent(); // ul, rodzic klikniętego elementu li
    var input = $(ul).find('input'); // ten input element
    // nadaj wartosc
    $(input).val($(klikniety).text());
}

// LEVEL 02 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

// geberuje faktyczny kontent obiektu dla pdfmake

function kontent(etyk) {
    
    var pdfdata = [];
    /* */
    while( etyk.left > etyk.baton ) {
        pdfdata = onePage(etyk, pdfdata); // wygeneruj i dodaj kolejną stronę/etykietę do pdf'a
        etyk.left -= etyk.baton;
        etyk.lnr += etyk.indec; // nr batona/strony
    }
    pdfdata = onePage(etyk, pdfdata);
    return pdfdata;
    
}
/* Generujemu dnae dla jednej strony pdf'a */
function onePage( etyk, strony ) {
    
    var last;
    
    if( etyk.left > etyk.baton ) { // czyli to nie ostatnia strona - chcemy pagebrake
        last = { text: numberSeparator(etyk.naklad, " "), style: 'normal', margin: [0, 0, 0, 0], pageBreak: 'after' };
    } else {
        last = { text: numberSeparator(etyk.naklad, " "), style: 'normal', margin: [0, 0, 0, 0] };
    }
    strony.push(        
        {
            text: [
                { text: etyk.job, style: 'numer', bold: true},
                { text: ' (' + etyk.order + ')', style: 'numer'}
            ]
        },
        { text: 'produkt:', style: 'textlabel', margin: [ 0, 3, 0, 0 ] },
        { text: etyk.name, style: 'product'},
        {
            columns: [
                [
                    { text: 'ilość w opakowaniu:', style: 'textlabel' },
                    { text: etyk.baton, style: 'normal' }
                ],
                [
                    { text: 'opakowanie nr:', style: 'textlabel', alignment: 'right' },
                    { text: etyk.lnr + etyk.batons, style: 'normal', alignment: 'right' }
                ]
            ]
        },
        { text: 'zamówiona ilość:', style: 'textlabel' },        
        last
    );
    return strony;
}

function numberSeparator(x, sep) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, sep);
}