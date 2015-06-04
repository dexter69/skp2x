$(function() {    
    
    /*
     *  PERSO - change date
     */
    $("td.changable").click(function() {
        interfejs( this, 'short', theurl );
    });
    
    $("dd.changable").click(function() {
        interfejs( this, 'long', theurl );
    });
    
});