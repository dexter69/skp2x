// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Obiekt opisujący filter ludzików
let ludziki = globalAppData.privHandlowcy
let thePeopleFilterHeader = {content:'serverSelectFilter', options: ludziki};

// Tabela ze zleceniami
let privateOrders = {//,header:["Category",  {content:'selectFilter'}]
    id: "privo",
    view:"datatable",
    theUserId: globalAppData.loggedInUser.id, //0, //	id użytkownika, którego zamówienia chcemy wyświetlić    
    columns:[
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"WebixPrivateOrder.id", header:"id", adjust:true },
        //{ id:"WebixPrivateOrder.nrTxt", header:"Nr", adjust:true },
        { id: "WebixCustomer.name", header: "Klient",  fillspace:true },                
        { id: "WebixPrivateOrderOwner.name", header: [ thePeopleFilterHeader ] , width:108 },
        //{ id: "creatorName", header: [{content:'selectFilter'} ] , width:105 },
        { id: "WebixPrivateOrder.stop_day", header:"Termin", adjust: true }        
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
            })
    },
    on:{
        'onBeforeFilter': function() {            
            privateOrders.theUserId = this.getFilter("WebixPrivateOrderOwner.name").value;
            //webix.message("onBeforeFilterTen theId = " + privateOrders.theUserId);
        },
        /**
         * Problem: przy załadowaniu strony mamy filter na "Wszyscy" ustawiony, a ładują się dane
         * dla zalogowanego użytkownika (tak jak zresztą chcemy). Wykorzystujemy zdarzenie 'onAfterLoad',
         * by to skorygować. Warunek jest po to by ta korekcja zachodziła tylko przy pierwszej inicjalizacji
         * (tylko wtedy warunek jest spełniony). Być może istnieje lepszy sposób ustawienia filtra czy coś.
         */  
        'onAfterLoad': function(){           
            if( this.getFilter("WebixPrivateOrderOwner.name").value != privateOrders.theUserId ) {                
                this.getFilter("WebixPrivateOrderOwner.name").value = privateOrders.theUserId;
            }
        }
    } 
};



function getTheRecords( theId ) { // id Handlowca, którego zamówienia chcemy

    webix.ajax().post("webixOrders/getPrivateOrders.json", { opiekunId: theId }, function(text, data){
        data = data.json(); 
        console.log(data);
        //$$("privo").parse( data.records );
        $$("privo").refresh();
    });
}

function gibon( argument ) { return argument;}

function testXYZ() {

    var promise = webix.ajax().post("webixOrders/getPrivateOrders.json", {id: 1});

    promise.then(function(abc){
        //console.log(abc);
        $$("privo").parse( promise );
    }).fail(function(err){
        console.log(err);
    });
}

function testABC() {

    webix.ajax().post("webixOrders/getPrivateOrders.json", {opiekunId: 0}, function(text, data){
        //webix.message(text);
        data = data.json(); 
        console.log(data);
        $$("privo").parse( data.records );
    });
}