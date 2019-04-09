// Obsługa kontrolki, do potwierdzania akcji zamykania zamówienia

let cloConWi = { // close confirm widget

    zamknij: false,    

    servZamknij: function(){

        $("#confirm-stuff").addClass("up"); // pokaz poupa

        // podepnij obsługę buttonów
    
        /*
        $("#confirm-stuff .sterowanie button.cancel").click(function(){
            cloConWi.serveCancelButt();
        }); 
        */

       $("#confirm-stuff .sterowanie button.cancel").click(
           //this.test
           this.serveCancelButt
       ); 

        $("#confirm-stuff .sterowanie button.confirm").click(function(){
            cloConWi.serveConfirmButt();
        }); 
    },

    serveCancelButt: function(){

        console.log("Anuluj was clicked!");
        console.log(this);
        this.closeConfirm();
    },

    serveConfirmButt: function(){

        console.log("Confirm was clicked!");
        this.closeConfirm();
    },

    closeConfirm: function(){
        $("#confirm-stuff").removeClass("up");
    }

}

$(function() {

    // Zainicjuj obsługę
    //cloConWi.init();

    $( "#EventViewForm" ).submit(function( event ) { 
        
        console.log("Point: 2");    
        
        if( cloConWi.zamknij ) {    // Czyli klikniety był przycisk Zamknij
            console.log("Point: 4");
            cloConWi.zamknij = false; // na wszelki wypadek
            event.preventDefault(); // nie chcemy submita
            cloConWi.servZamknij(); // obsługa zamykania - ilosci kart
        }
    });

    /**
     * Gdy ktoś kliknie zamknij, to ustawiamy tą zmienną, dzięki czemu powyższa obsługa submit
     * "wie", że zamknij było kliknięte */
    $( "input[co='17']" ).click(function(){ 
        console.log("Point: 3");       
        cloConWi.zamknij = true;
    });

    

});