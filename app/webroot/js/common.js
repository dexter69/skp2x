$(function() {    
    /*
     *  SZUKANIE
     */
    
    $(document).keypress(function(e) {
        if ( e.which === 102 && !$(e.target).is('input, textarea') ) {
            fireSearch();
        } 
    });

    $( '.klose-mark' ).click(function() {
        fireSearch();
    });
    
});

