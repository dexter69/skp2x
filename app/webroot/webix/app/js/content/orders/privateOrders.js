// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Definicje poszczególnych kolumn

let
    // kolumna indeksująca
    indexTablicy = { id:"index", header:"", sort:"int"
                    , adjust:true //width: 40 
    }, 
    idZamowienia = { 
        id: 'orderId',
        header:"Id"
       // , width:60
       , adjust:true
    },
    klient = { 
        id: 'costomerName',
        header:"Klient"
        ,  fillspace:true
        //, width: 60
    },
    termin = { 
        id: 'termin',
        header:"Termin"
        , adjust: true
        //, width:90
    },
    status = {
        id: 'status',
        header:"Status"
        , adjust: true
        //, width:60
    }
;

let prywatneZamowienia = [
    { id:1, orderId: 9946, costomerName:"The Shawshank Redemption",  termin: '29 X 2018', status: 'PRYWATNE'},
    { id:2, orderId: 2569, costomerName:"The Godfather",             termin: '19 X 2018', status: 'PRYWATNE'},
    { id:3, orderId: 6974, costomerName:"The Godfather: Part II",    termin: '15 X 2018', status: 'PRYWATNE'},
    { id:4, orderId: 3994, costomerName:"Pulp fiction",              termin: '23 X 2018', status: 'PRYWATNE'}
];

function gibon( argument ) { return argument;}

// Tabela ze zleceniami

let privateOrders = {
	view:"datatable",	
    columns:[
        indexTablicy,        
        idZamowienia,
        klient,
        termin,
        status
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    },
    //data: prywatneZamowienia
    //data: gibon(prywatneZamowienia)   
    url: "webixOrders/testData.json"
};