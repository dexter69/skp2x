/* Funkcje dla label.js */

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

