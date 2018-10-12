// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Tabela ze zleceniami

let privateOrders = {//,header:["Category",  {content:'selectFilter'}]
    id: "privo",
	view:"datatable",	
    columns:[
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"id", header:"id", adjust:true },
        { id: "customerName", header: "Klient",  fillspace:true },                
        { id: "creatorName", header: [{content:'serverSelectFilter', options: globalAppData.privHandlowcy} ] , width:105 },
        //{ id: "creatorName", header: [{content:'selectFilter'} ] , width:105 },
        { id: 'stop_day', header:"Termin", adjust: true }        
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    },    
    //url: "post->webixOrders/getPrivateOrders.json"
    data: testXYZ()
    
};

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