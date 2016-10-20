/* Funkcje dla label.js */


/* Konstruktory strony etykiety */
var page = {
    firstLine: function(order, job) {
        this.text = [
            { text: job, style: 'numer', bold: true},
            { text: '  <' + order + '>', style: 'numer'}
        ];
    },
    secondLine: function(val, lbltxt) {       
       this.text = val;
       if(lbltxt) { //znaczy tprodukujemy treść label'a       
           this.style = 'textlabel';
           this.margin = [ 0, 3, 0, 0 ]; 
       } else { //nazwa produktu           
           this.style = 'product';
       }
    },    
    thirdLineV2: function(naklad, inbaton) {
    
        this.columns = [
            [
                { text: 'zamówiona ilość:', style: 'textlabel' },
                { text: naklad, style: 'normal' }
            ],
            [
                { text: 'ilość w opakowaniu:', style: 'textlabel', alignment: 'right' },
                { text: inbaton, style: 'normal', alignment: 'right' }
            ]
        ];
    },    
    fourthLineV2: function(val, lbltxt) {
        this.text = val;
        this.alignment = 'right';
        if(lbltxt) { //znaczy tprodukujemy treść label'a     
            this.style = 'textlabel';
        } else { // wartość
            this.style = 'normal';
            this.pageBreak = 'after'; 
        }
    }
};

function setProperInput() {
    
    // W razie odświeżenia strony chcemy skorygować zawartość pola input
    $('.label-summary input').each(function(){
        $(this).val($(this).attr('value'));
    });
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

function numberSeparator(x, sep) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, sep);
}

