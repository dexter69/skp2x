/*
Obsługa dodawania/edycji kart w trybie multi
---
Wykorzystywane przez card.js */


function multi() {

    let fieldset = '#CardAddForm fieldset';
    let legend = '#CardAddForm fieldset > legend';
    let span = '#CardAddForm fieldset > legend > span';

    //Input do ust. ilosci kart
    let theInput = '#CardAddForm fieldset > div.mti input';

    $(span).click( function() {
        
        $( theInput ).val(1); // przy zmianie zresetuj wartość        
        $( fieldset ).toggleClass( "mono" );
        $( fieldset ).toggleClass( "multi" );
    });
}