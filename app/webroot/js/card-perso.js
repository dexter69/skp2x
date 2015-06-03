$(function() {    
    
    /*
     *  PERSO - change date
     */
    $("td.changable").click(function() {
        interfejs( this, 'short' );
    });
    
    $("dd.changable").click(function() {
        interfejs( this, 'long' );
    });
    
});