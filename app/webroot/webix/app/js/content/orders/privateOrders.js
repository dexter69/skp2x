// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Tabela ze zleceniami

let privateOrders = {
	view:"datatable",	
    columns:[
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"orderId", header:"Id", adjust:true },
        { id: "customerName", header:"Klient",  fillspace:true },
        { id: "opiekun", header:"Opiekun", adjust:true },
        { id: 'termin', header:"Termin", adjust: true }        
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    },
    //data: prywatneZamowienia
    //data: gibon(prywatneZamowienia)   
    url: "webixOrders/testData.json"
};

function gibon( argument ) { return argument;}