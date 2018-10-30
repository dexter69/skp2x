// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Obiekt opisujący filter ludzików
let thePeopleFilterHeader = {content:'serverSelectFilter', options: []};

// Tabela ze zleceniami
let privateOrders = {
    id: "privo",
    view:"datatable",
    select: true, // umożliwia selekcję
    gravity: 1.7,    
    theUserId: globalAppData.loggedInUser.id, // id użytkownika, którego zamówienia chcemy wyświetlić    
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
            $$(theOrderDetail_listOfCards.id).clearAll(true);
            $$(theOrderDetail_listOfCards.id).hide();
            // czyscimy component ze szczegółami zamówienia
            $$(theOrderDetail.id).define("template", "");
            $$(theOrderDetail.id).refresh();            
        },
        'onAfterSelect': function(id){ 
            $$(theOrderDetail_listOfCards.id).show();
            $$(theOrderDetail_listOfCards.id).clearAll(true); // czyscimy listę kart, bo mogła być stara
            
            // id tego zamówienia w bazie SKP
            let theOrderId = $$(privateOrders.id).getItem(id).WebixPrivateOrder_id; 

            // spreparuj prawidłowy url
            let url = "webixOrders/getOneOrderLight/" + theOrderId + ".json";

            // pobierz świeże dane dot. tego zamówienia
            webix.ajax(url).then(function(data){   
                let dane = data.json();  
                if( dane.WebixOrder_ileKart ) { // Jeżeli są jakieś karty
                    // karty tego zamówienia
                    let karty = dane.WebixCard;
                    $$(theOrderDetail_listOfCards.id).parse(karty); 
                }
                // Tworzymy template (bo nie hcemy by nam się cokolwiek wyświetlało, jak nie ma danych)                                
                $$(theOrderDetail.id).define("template", globalAppData.template.theOrderDetail);
                $$(theOrderDetail.id).parse({
                    id: dane.WebixOrder_id,
                    termin: dane.WebixOrder_stop_day
                });
            });                               
        }
    } 
};