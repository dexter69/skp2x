// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Obiekt opisujący filter ludzików
let ludziki = globalAppData.privHandlowcy
let thePeopleFilterHeader = {content:'serverSelectFilter', options: ludziki};

// Tabela ze zleceniami
let privateOrders = {//,header:["Category",  {content:'selectFilter'}]
    id: "privo",
    view:"datatable",
    theUserId: 0, //	id użytkownika, którego zamówienia chcemy wyświetlić    
    columns:[
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"id", header:"id", adjust:true },
        { id: "customerName", header: "Klient",  fillspace:true },                
        { id: "creatorName", header: [ thePeopleFilterHeader ] , width:105 },
        //{ id: "creatorName", header: [{content:'selectFilter'} ] , width:105 },
        { id: 'stop_day', header:"Termin", adjust: true }        
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    },    
    urlx: "post->webixOrders/getPrivateOrders.json",
    //https://docs.webix.com/desktop__server_customload.html
    url: function( /*details*/){ // details było zadeklarowane w przykładzie (po co?), ale nie jest potrzebne
            let url = "webixOrders/getPrivateOrders/" + privateOrders.theUserId + ".json";
            return webix.ajax(url).then(function(data){
                let dane = data.json();                
                // Lidziki aktualnie mający prywatne zamówienia
                thePeopleFilterHeader.options = dane.peopleHavingPrivs;
                return dane.records;  // w records mamy faktyczne dane                            
            })
    },
    //data: testABC(),
    //data: getTheRecords(0),//testABC(),
    //on:{'onItemClick': function(){alert("you have clicked an item");}} 
    on:{
        'onBeforeFilterA': function(){ webix.message("onBeforeFilter"); },
        'onBeforeFilter': function() {            
            privateOrders.theUserId = this.getFilter("creatorName").value;
            webix.message("onBeforeFilterTen theId = " + privateOrders.theUserId);
            //console.log(theCreatorId);
            //getTheRecords(theCreatorId);
        },
        //alert("onBeforeFilter");
        'onAfterFilterX': function(){
            webix.message("onAfterFilter");   
            privateOrders.columns[3].header[0].options = [
                {id: 7, value: "Gibon"},
                {id: 8, value: "Orangutan"}
            ];
            $$("privo").refreshFilter();
            this.getFilter("creatorName").value = 7;            
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