/* 
 *  Obsług przedpłaty po nowemu
 * 
 */

// obsługa otwierania i zamykania widżetu

var theSpan = ".ikony-handlowe > #the-dd-2"; //interesujący nas span z dolarami

$( document ).ready(function() {
   
    obslugaKlikniecia_wDolar();
});

// jak klikniemy w dolar, to chcemy otwierać/zamykać widżet i wiedzieć,
// która opcja (kolor) została wybrana
function obslugaKlikniecia_wDolar() {
    
    $(theSpan + " > i").click( function(){
        console.log($(this).attr('dolar'));
        
        if( $(theSpan).hasClass('clickable') ) { // widżet działa tylko gdy jest clickable
            if( $(theSpan).hasClass('open') ) { // jest otwarty
                $(theSpan).removeClass('open'); // zamknij
            } else { // jest zamkniety
                $(theSpan).addClass('open'); // otwórz
            }
        }
    });
}


