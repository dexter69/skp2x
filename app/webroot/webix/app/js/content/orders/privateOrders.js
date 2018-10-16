// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Tabela ze zleceniami

webix.ui({
    view:"datatable",
    autoConfig:true,
    url:function(details){
        return webix.ajax("data.php?filterByUser="+userId).then(function(data){
            var js = data.json();
            var new_js = [];
 
            for (key in js){
                new_js.push({
                    id:key, 
                    name:js[key].name
                });
            };
 
            return new_js;
        })
    }
});

let opcje = globalAppData.privHandlowcy;

let privateOrders = {//,header:["Category",  {content:'selectFilter'}]
    id: "privo",
	view:"datatable",	
    columns:[
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"id", header:"id", adjust:true },
        { id: "customerName", header: "Klient",  fillspace:true },                
        { id: "creatorName", header: [{content:'serverSelectFilter', options: opcje} ] , width:105 },
        //{ id: "creatorName", header: [{content:'selectFilter'} ] , width:105 },
        { id: 'stop_day', header:"Termin", adjust: true }        
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    },    
    urlx: "post->webixOrders/getPrivateOrders.json",
    //https://docs.webix.com/desktop__server_customload.html
    url:function(details){
        return webix.ajax("data.php?filterByUser="+userId).then(function(data){
            var js = data.json();
            var new_js = [];
 
            for (key in js){
                new_js.push({
                    id:key, 
                    name:js[key].name
                });
            };
 
            return new_js;
        })
    },
    //data: testABC(),
    //data: getTheRecords(0),//testABC(),
    //on:{'onItemClick': function(){alert("you have clicked an item");}} 
    on:{
        'onBeforeFilter': function(){ webix.message("onBeforeFilter"); },
        'onBeforeFilterX': function() {
            let theCreatorId = 0;

            //webix.message("onBeforeFilter");
            theCreatorId = this.getFilter("creatorName").value;
            //console.log(theCreatorId);
            getTheRecords(theCreatorId);
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