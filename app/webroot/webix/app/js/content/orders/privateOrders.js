// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Obiekt opisujący filter ludzików
let thePeopleFilterHeader = {content:'serverSelectFilter', options: []};

// Tabela ze zleceniami
let privateOrders = {
    id: "privo",
    view:"datatable",
    select: true, // umożliwia selekcję
    //gravity: 1.5, // 1.4x większe niż ta druga kolumna ( jeżeli są 2-ie)
    theUserId: globalAppData.loggedInUser.id, //0, //	id użytkownika, którego zamówienia chcemy wyświetlić    
    columns:[
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"WebixPrivateOrder_id", header:"id", adjust:true },
        //{ id:"WebixPrivateOrder.nrTxt", header:"Nr", adjust:true },
        { id: "WebixCustomer_name", header: "Klient",  fillspace:true },                
        { id: "WebixPrivateOrder_ileKart", header: "<span class='webix_icon fa-credit-card'></span>",  adjust: true  }, 
        { id: "WebixPrivateOrderOwner_name", header: [ thePeopleFilterHeader ] , width:108 },        
        { id: "WebixPrivateOrder_stop_day", header:"Termin", adjust: true }        
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    },        
    //https://docs.webix.com/desktop__server_customload.html
    url: function( /*details*/){ // details było zadeklarowane w przykładzie (po co?), ale nie jest potrzebne
            let url = "webixPrivateOrders/getTheOrders/" + privateOrders.theUserId + ".json";
            return webix.ajax(url).then(function(data){
                let dane = data.json();                
                // Lidziki aktualnie mający prywatne zamówienia
                thePeopleFilterHeader.options = dane.peopleHavingPrivs;
                return dane.records;  // w records mamy faktyczne dane                            
            });
    },
    on:{
        'onBeforeFilter': function() {            
            privateOrders.theUserId = this.getFilter("WebixPrivateOrderOwner_name").value;
            //webix.message("onBeforeFilterTen theId = " + privateOrders.theUserId);
        },
        /**
         * Problem: przy załadowaniu strony mamy filter na "Wszyscy" ustawiony, a ładują się dane
         * dla zalogowanego użytkownika (tak jak zresztą chcemy). Wykorzystujemy zdarzenie 'onAfterLoad',
         * by to skorygować. Warunek jest po to by ta korekcja zachodziła tylko przy pierwszej inicjalizacji
         * (tylko wtedy warunek jest spełniony). Być może istnieje lepszy sposób ustawienia filtra czy coś.
         */  
        'onAfterLoad': function(){           
            if( this.getFilter("WebixPrivateOrderOwner_name").value != privateOrders.theUserId ) {                
                this.getFilter("WebixPrivateOrderOwner_name").value = privateOrders.theUserId;
            }
            // po zmianie filtra (wybrany inny handlowiec), czyścimy listę kart
            $$(orderDetails_listOfCards.id).clearAll(true);
        },
        'onAfterSelect': function(id){                         
            $$(orderDetails_listOfCards.id).clearAll(true); // czyscimy listę kart, bo mogła być stara

            // id tego zamówienia w bazie SKP
            let theOrderId = $$(privateOrders.id).getItem(id).WebixPrivateOrder_id; 

            // spreparuj prawidłowy url
            let url = "webixOrders/getOneOrderLight/" + theOrderId + ".json";

            // pobierz świerze dane dot. tego zamówienia
            webix.ajax(url).then(function(data){                  
                let karty = data.json().WebixCard; // karty tego zamówienia
                if( karty.length ) { // zamówienie ma jakieś karty
                    $$(orderDetails_listOfCards.id).parse(karty); // uaktualnij listę
                }                                
            });                               
        }
    } 
};