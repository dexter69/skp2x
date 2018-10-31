// kontrolery zdarzeń dla listOfPrivateOrders

let onBeforeFilterHandler = function() {            
    conf.theUserId = this.getFilter("WebixPrivateOrderOwner_name").value;        
}

/**    
 * Problem: przy załadowaniu strony mamy filtr ustawiony na "Wszyscy", a ładują się dane dla
 * zalogowanego użytkownika (tak jak zresztą chcemy). Wykorzystujemy zdarzenie 'onAfterLoad',
 * by to skorygować. Warunek jest po to by ta korekcja zachodziła tylko przy pierwszej inicjalizacji
 * (tylko wtedy warunek jest spełniony). Być może istnieje lepszy sposób ustawienia filtra czy coś.
 */

let onAfterLoadHandler = function(){           
    if( this.getFilter("WebixPrivateOrderOwner_name").value != conf.theUserId ) {                
        this.getFilter("WebixPrivateOrderOwner_name").value = conf.theUserId;
    }
    // po zmianie filtra (wybrany inny handlowiec), czyścimy listę kart
    /*
    $$(theOrderDetail_listOfCards.id).clearAll(true);
    $$(theOrderDetail_listOfCards.id).hide();
    */
    // czyscimy component ze szczegółami zamówienia
    /*
    $$(theOrderDetail.id).define("template", "");
    $$(theOrderDetail.id).refresh();            
    */
}

let onAfterSelectHandler = function(id){ 
    /*
    $$(theOrderDetail_listOfCards.id).show();
    $$(theOrderDetail_listOfCards.id).clearAll(true); // czyscimy listę kart, bo mogła być stara
    */
    // id tego zamówienia w bazie SKP
    let theOrderId = $$(listOfPrivateOrders.id).getItem(id).WebixPrivateOrder_id; 

    // spreparuj prawidłowy url
    let url = "webixOrders/getOneOrderLight/" + theOrderId + ".json";

    // pobierz świeże dane dot. tego zamówienia
    webix.ajax(url).then(function(data){   
        let dane = data.json();  
        //console.log(dane);
        if( dane.WebixOrder_ileKart ) { // Jeżeli są jakieś karty
            // karty tego zamówienia
            let karty = dane.WebixCard;                
            //$$(theOrderDetail_listOfCards.id).parse(karty); 
        }
        // Tworzymy template (bo nie hcemy by nam się cokolwiek wyświetlało, jak nie ma danych)                                
        /*
        $$(theOrderDetail.id).define("template", globalAppData.template.theOrderDetail);
        $$(theOrderDetail.id).parse({
            id: dane.WebixOrder_id,
            termin: dane.WebixOrder_stop_day
        });
        */
    });                               
}