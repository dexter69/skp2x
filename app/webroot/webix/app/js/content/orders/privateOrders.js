// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Tabela ze zleceniami

let privateOrders = {//,header:["Category",  {content:'selectFilter'}]
	view:"datatable",	
    columns:[
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"id", header:"id", adjust:true },
        { id: "customerName", header: "Klient",  fillspace:true },                
        { id: "creatorName", header: [{content:'serverSelectFilter'} ] , width:105 },
        //{ id: "creatorName", header: [{content:'selectFilter'} ] , width:105 },
        { id: 'stop_day', header:"Termin", adjust: true }        
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    },
    //data: prywatneZamowienia
    //data: gibon(prywatneZamowienia)   
    //url: "webixOrders/testData.json"
    //url: "rest->webixOrders/privateOrders/0.json"    
    //url: "post->webixOrders/privateOrders.json"    //
    url: "post->webixOrders/privOrders.json"
    //url: "webixOrders/privOrders.json"
};

function gibon( argument ) { return argument;}