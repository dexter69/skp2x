/**
 * Otwieranie zamówień w trybie serwisowym
 */


// Shorthand for $( document ).ready()
$(function() { 

    /**
     * base, order_id globalne zmienne zdefiniowane w order/pay.js     */
    let orderId4servo = order_id,
        servoUrl = base + "servos/servo.json";

    // Użytkownik kliknął w ikonkę serwisowego otwierania
    $("#servo-span").click(function(){
        servoSpinnerON(); // Włącz kręciołe
        let  servoPosting = $.post( servoUrl, { "id": orderId4servo } );

        servoPosting.done(function( answer ) {             
            servoDone( answer );
        });

        servoPosting.fail( function(){
            servoSpinnerON(false); // Wyłącz kręciołe
            servoFail( servoPosting.status, orderId4servo );
        });
    });    
});

/**
 * Włączamy lub wyłączamy kręciołe podczas komunikacji z serwerem
 *  @param {boolean} action 
 */
function servoSpinnerON( action = true ) {

    if( action ) { // Włączamy
        $("#servo-span").addClass("ukryty");
        $("#servo-spinner-span").removeClass("ukryty");        
    } else { // Wyłączamy
        $("#servo-span").removeClass("ukryty");
        $("#servo-spinner-span").addClass("ukryty");
    }

}

/**
 * @param { object } dataFromServer - odpowiedź serwera */

function servoDone( dataFromServer ) {
    //console.log( dataFromServer);
    if( dataFromServer.success ) { // znaczy: pomyślnie udało się otworzyć zamówienie
        //console.log("Yupii!");
        location.reload(true); // przeładuj stronę
    } else { // W razie błędu
        servoSpinnerON(false); // Wyłącz kręciołe
        console.log("Nie udało się otworzyć zamówienia!");
    }
    
}

/**
 * Obsługa błędu przy komunikacji  */
function servoFail( status, theRedirectUrl ) {
    console.log(status + ", " + theRedirectUrl);
    if( status === 403) { // traktujemy to, że użytkownik nie jest zalogowany
        // przekierowujemy do logowania
        location.assign(theRedirectUrl);
    } else {
        console.log("FAIL-Y");
        printErr(4124); // zdefiniowana w order/pay.js
    }
}