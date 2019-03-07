/**
 * Otwieranie zamówień w trybie serwisowym
 */


// Shorthand for $( document ).ready()
$(function() { 

    /**
     * base, order_id globalne zmienne zdefiniowane w order/pay.js     */
    let base4servo = base,
        orderId4servo = order_id,
        servoUrl = base + "orders/servo.json";

    // Użytkownik kliknął w ikonkę serwisowego otwierania
    $("#servo-span").click(function(){
        //console.log( base4servo, orderId4servo ); 
        let  servoPosting = $.post( servoUrl, { "id": orderId4servo } );

        servoPosting.done(function( answer ) { // sukces, dostaliśmy dane        
            // uaktualnij stan faktyczny i wygląd na stronie
            console.log(servoPosting.status);
        });
        
        servoPosting.fail(function() { // błąd, coś poszło nie tak        
            if( servoPosting.status === 403) { // traktujemy to, że użytkownik nie jest zalogowany
                // przekierowujemy do logowania
                location.assign(base4servo + 'users/login');
            } else { console.log("FAIL-Y"); printErr(4124);} //inny błąd
        });

    });    
});