/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    /*
    $( "#kwi" ).click(function(){
        var tmp = $(this).data("lan");
        var text = $(this).text();
        $(this).text(tmp);
        $(this).data("lan", text);
    });
    
    $( "#burok" ).keyup(function() {
        console.log( "Handler for .keyup() called." );
    });
    */
    console.log(model);
    setupKlodka();
    
  });



// ustaw kłodkę do klikania
function setupKlodka() {
        
    $("[data-editable=true] i").click(function(){
        console.log('kliknal!');
    });
}
