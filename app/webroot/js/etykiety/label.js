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
        naklad: $(obj).data('naklad'),
        baton: $($(obj).parent().find("input")).val(),
        
        boxq: true, /* czy generujemy ilość w kart w batonie.
        False oznacza puste (miejsce na ręczny wpis) -> pociąga to równieżź za sobą fakt,
        że boxnr będzie false */
        boxnr: true, /* numerowanie batonów, czyli 1, 2, 3.... */
        boxsum: true, /* sumowanie batonów - będzie (np.) 1/12, 2/12, ..., 12/12 */
        lang: 'pl',
        
        lnr: 1, // nr strony/batona, zaczynamy od 1,
        indec: 1
    };
    
    if( label.baton === "" || label.baton === null ) {
        /* Pole ilości w formularzu puste, sprawdzanie null na wszelki wypadek.
         * Znaczy, że użytkownik nie chcemy drukować ilości w batonie,
         * więc nie liczymy również sumy batonów, będzie tylko 1 etykieta */        
        label.baton = 0;
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
    // bez drukowania ilości w batonie lub bez numeracji batona => zawsze 1 etykieta
    if( !label.boxq || !label.boxnr) {
        label.left = label.rest = 0;
    } else { //wiele etykiet
        label.rest = label.naklad;
    }
    //dexpage.etyk = label;
    //kontent(label);
    //var k2 = kontent2();
    //console.log(k2);
    docDefinition.content = kontent(label);       
    // open the PDF in a new window
    pdfMake.createPdf(docDefinition).open();
}

/* Chcemy coś takiego - na podstawie danych dla etykiet
 * Robimy strukturę, która się składa ze stałych elementów i zmiennych.
 * Później powielamy ją, zmieniając tylko elementy zmienne */

/* Obiekt trzymający strukturę strony pdf etykiety */

var dexpage = { // wartości "text" przykładowe
  pagebreak: true,
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
      value:  { text: ' ', style: 'normal' }
  },
  boxnr: {
      label: true,
      labval: { text: 'labtxt', style: 'textlabel', alignment: 'right' },
      value:  { text: ' ', style: 'normal', alignment: 'right' }
  },
  naklad: {
      label: true,
      labval: { text: 'labtxt', style: 'textlabel' },
      value:  { text: '1000', style: 'normal', margin: [0, 0, 0, 0], pageBreak: 'after' /**/ }
  },
  
  etyk: {},  /* to zawiera wrtości sczytane z interfejsu użytkownika, czli info,
                jak etykiety mają być konstruowane */
    
    
  
  /* Ustawiamy wartości na podstawie danych o etykiecie.
   * Większość tych wartości, będzie stałych dla każdej strony pdf'a */
  presetValues: function() {

      // numery zleceń
      this.zlecnr.value.text[0].text = this.etyk.job;
      this.zlecnr.value.text[1].text = " /" + this.etyk.order + "/";

      // nazwa produktu (karty)
      this.produkt.labval.text = this.lbs.produkt[this.etyk.lang];
      this.produkt.value.text = this.etyk.name;

      // ilość w batonie
      this.inbox.labval.text = this.lbs.inbox[this.etyk.lang]; // etykieta zawsze
      if( this.etyk.boxq ) { // czy generujemy wartość /bo może być ręcznie/        
        this.inbox.value.text = this.etyk.baton;
      }

      // licznik batonów
      this.boxnr.labval.text = this.lbs.boxnr[this.etyk.lang];
      // wartości (numery batona) nie wpisujemy, bo zostanie to zrobione na etapie generacji

      // nakład
      this.naklad.labval.text = this.lbs.naklad[this.etyk.lang]; 
      this.naklad.value.text = numberSeparator(this.etyk.naklad, " ");
    },
  
  // ustaw numer batona na nr. Ustawiamy w structure1
  setBatonNr1: function(nr) { 
      if(this.etyk.boxnr) { // jeżeli batony mają być numerowane
          this.structure1[3].columns[1][1].text = nr;
      }
  },  
  // ustaw ilość w batonie do q
  setBoxQ1: function() { 
      if( this.etyk.boxq && this.etyk.rest < this.etyk.baton ) {
          this.structure1[3].columns[0][1].text = this.etyk.rest.toString();
      }
  },
  
  structure1: [],
  /* Tworzy ogólną strukturę strony, do której będziemy zapisywać tylko zmienne rzeczy
   * później, układ (na stronie) opcja 1 */
  makeStructre1: function() {
      var arr, j=[], d=[];      
      j[0] = this.inbox.labval; j[1] = this.inbox.value;
      d[0] = this.boxnr.labval; d[1] = this.boxnr.value;
      arr = [
          this.zlecnr.value,
          this.produkt.labval,
          this.produkt.value,
          {
            columns: [ j, d
                //[this.inbox.labval, this.inbox.value],
                //[this.boxnr.labval, this.boxnr.value]
            ]
          },
          this.naklad.labval,
          this.naklad.value
      ];
      //this.structure1 = arr;
      return arr;
  }
  
};


function kontent2() {
    
    var konc, i = 0, pdfdata = [];
    
    dexpage.presetValues(); // ustaw wstępnie wartości etykiety
    if( dexpage.etyk.boxnr){ // jeżeli batony mają być numerowane
        if( dexpage.etyk.boxsum  && dexpage.etyk.baton !== 0 ) { // jeżeli ma być suma batonów
            konc = '/' + Math.ceil(dexpage.etyk.naklad/dexpage.etyk.baton);
        } else {
            konc = "";
        }
    }
    var structure = dexpage.makeStructre1(); //stwórz strukturę strony
    console.log("tuuu");
    console.log(structure);
    /* To co teraz robimy, to aktualizujemy zmienne elementy na stronie i generujemy
     * dane do pdf'a*/
    
    do {
        //dexpage.setBoxQ1(); // ustaw ilość w batonie 
        if( dexpage.etyk.boxq && dexpage.etyk.rest < dexpage.etyk.baton ) {
            structure[3].columns[0][1].text = dexpage.etyk.rest.toString();
        }
        //dexpage.setBatonNr1(++i + konc); // ustaw wrtość nr batona   
        if(dexpage.etyk.boxnr) { // jeżeli batony mają być numerowane
            structure[3].columns[1][1].text = ++i + konc;
        }
        
        // dodaj do pdfdata dane tej strony
        pdfdata = addPage(pdfdata, structure);
        
        dexpage.etyk.rest -= dexpage.etyk.baton; // zmniejsz "nakład" o ilość w batonie
        console.log(i);
    } while ( dexpage.etyk.rest > 0 );
    console.log(pdfdata);
    return pdfdata;
}


function addPage( strony, struktura ) {
    
    strony.push(
            struktura[0], struktura[1],
            struktura[2], struktura[3],
            struktura[4], struktura[5]
    );
    return strony;
}

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
    console.log(pdfdata);
    return pdfdata;
}
