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
        /*
        console.log("baton = " + etykieta.baton);
        if( etykieta.baton == "") {
            console.log("puste");
        } else {
            console.log("NIE puste");
        }
        */
        // wykreuj pdf
        makeLabPdf(etykieta);
    });
});

// LEVEL 01 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

function setProperInput() {
    
    // W razie odświeżenia strony chcemy skorygować zawartość pola input
    $('.label-summary input').each(function(){
        $(this).val($(this).attr('value'));
    });
}

// odczytaj dane dla etykiety i zformatuj
function getLabelData( obj ) { // obj reprezentuje kliknięty element
    
    var label = { 
        job: '123/16',
        order: '254/16 MS',
        name: $(obj).data('product'),
        naklad: $(obj).data('naklad'),
        baton: $($(obj).parent().find("input")).val(),
        lnr: 1, // nr strony/batona, zaczynamy od 1,
        indec: 1,
        boxq: true, /* czy generujemy ilość w kart w batonie.
        False oznacza puste (miejsce na ręczny wpis) -> pociąga to równieżź za sobą fakt,
        że boxnr będzie false */
        boxnr: true, /* numerowanie batonów, czyli 1, 2, 3.... */
        boxsum: true, /* sumowanie batonów - będzie (np.) 1/12, 2/12, ..., 12/12 */
        lang: 'pl'
    };
    
    if( label.baton === "" || label.baton === null ) { /* znaczy nie chcemy drukować ilości,
        * nie liczymy sumy batonów, będzie tylko 1 etykieta */        
        label.baton = 0; label.left = 0; 
        label.boxq = false;        
    } else {
        label.left = label.naklad;
    }
    
    return label;
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

/* Obiekt trzymający strukturę strony pdf etykiety */

var dexpage = { // wartości "text" przykładowe
  pagebreak: true,
  lang: 'pl',
  lbs: {        // teksty do etykietek, typu "produkt", itp.
      produkt:  {pl: 'produkt:', en: 'product:'},
      inbox:    {pl: 'ilość w opakowaniu:', en: 'batch:'},
      boxnr:    {pl: 'opakowanie nr:', en: 'batch no:'},
      naklad:   {pl: 'zamówiona ilość:', en: 'ordered quantity:'}
  },
  zlecnr: { // numery naszy zleceń
    label: false,
    value: {
        text: [
            { text: 'jobnr', style: 'numer', bold: true},
            { text: 'ordernr', style: 'numer'}
        ]
    }
  },
  produkt:{ 
      label: true,
      labval: { text: 'labtxt', style: 'textlabel', margin: [ 0, 3, 0, 0 ] },
      value:    { text: 'nazwa karty', style: 'product'}      
  },
  inbox: {
      label: true,
      labval: { text: 'labtxt', style: 'textlabel' },
      value:  { text: '500', style: 'normal' }
  },
  boxnr: {
      label: true,
      labval: { text: 'labtxt', style: 'textlabel', alignment: 'right' },
      value:  { text: '1/4', style: 'normal', alignment: 'right' }
  },
  naklad: {
      label: true,
      labval: { text: 'labtxt', style: 'textlabel' },
      value:  { text: '1000', style: 'normal', margin: [0, 0, 0, 0]/*, pageBreak: 'after'*/ }
  },
  structure1: [],
  /* Tworzy ogólną strukturę strony, do której będziemy zapisywać tylko zmienne rzeczy
   * później, układ (na stronie) opcja 1 */
  makeStructre1: function() {
      //return this.firstName + " " + this.lastName;
      this.structure1 = [
          this.zlecnr.value,
          this.produkt.labval,
          this.produkt.value,
          {
            columns: [
                [this.inbox.labval, this.inbox.value],
                [this.boxnr.labval, this.boxnr.value]
            ]
          },
          this.naklad.labval,
          this.naklad.value
      ];
  },
  /* Ustawiamy wartości na podstawie danych o etykiecie.
   * Są to wartości, które będą stałe dla każdej strony pdf'a */
  presetStructure1: function( etykdata ) {
      
      this.zlecnr.value.text[0].text
  }
};

// geberuje faktyczny kontent obiektu dla pdfmake

function kontent(etyk) {
    
    var pdfdata = [];
    
    if( etyk.baton !== 0 ) { /* == 0 oznacza, że będzie tylko 1 etykieta bez ilości w batonie i licznika */                
        etyk.batons = '/' + Math.ceil(etyk.naklad/etyk.baton);
        while( etyk.left > etyk.baton ) {
            pdfdata = onePage(etyk, pdfdata); // wygeneruj i dodaj kolejną stronę/etykietę do pdf'a
            etyk.left -= etyk.baton;
            etyk.lnr += etyk.indec; // nr batona/strony
        }
    } 
    pdfdata = lastPage(etyk, pdfdata);
    return pdfdata;
    
}
/* Generujemu dnae dla jednej strony pdf'a i nie ostatniej */
function onePage( etyk, strony ) {
    
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
        { text: numberSeparator(etyk.naklad, " "), style: 'normal', margin: [0, 0, 0, 0], pageBreak: 'after' }
    );
    return strony;
}

/* Generujemu ostatbią stronę pdf'a, bez page brake */
function lastPage( etyk, strony ) {
    
    var baton, druga;
    
    if( etyk.baton === 0 ) { // czyli nie drukujemy ilości batona i licznika
        baton = " ";
        druga = [];
    } else {
        baton = etyk.left.toString();
        druga = [
            { text: 'opakowanie nr:', style: 'textlabel', alignment: 'right' },
            { text: etyk.lnr + etyk.batons, style: 'normal', alignment: 'right' }
        ];
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
                    { text: baton, style: 'normal' }
                ],
                druga
            ]
        },
        { text: 'zamówiona ilość:', style: 'textlabel' },        
        { text: numberSeparator(etyk.naklad, " "), style: 'normal', margin: [0, 0, 0, 0] }
    );
    return strony;
}

function numberSeparator(x, sep) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, sep);
}