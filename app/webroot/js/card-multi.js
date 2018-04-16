/*
Obsługa dodawania/edycji kart w trybie multi
---
Wykorzystywane przez card.js */

function multi() {

    $('#CardAddForm fieldset > legend > span').click( function() {
        $( '#CardAddForm fieldset > legend' ).toggleClass( "mono" );
        $( '#CardAddForm fieldset > legend' ).toggleClass( "multi" );
    });
}