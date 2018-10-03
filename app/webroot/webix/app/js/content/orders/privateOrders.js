// Jak sama nazwa wskazuje, obsługa (listing) prywatnych handlowych

// Definicje poszczególnych kolumn

let
    indexTablicy = { id:"index",   header:"",           sort:"int"}, // kolumna indeksująca
    idZamowienia = { 
        id: 'orderId',
        header:"Id"
        //, width:60
    },
    klient = { 
        id: 'costomerName',
        header:"Klient"
        ,  fillspace:true
        //, width:60
    },
    termin = { 
        id: 'termin',
        header:"Termin"
        //, width:90
    },
    status = {
        id: 'status',
        header:"Status"
        //, width:60
    }
;

let prywatneZamowienia = [
    { id:1, orderId:9946, costomerName:"The Shawshank Redemption",  termin: '29 X 2018', status: 'PRYWATNE'},
    { id:2, orderId:2569, costomerName:"The Godfather",             termin: '19 X 2018', status: 'PRYWATNE'},
    { id:3, orderId:6974, costomerName:"The Godfather: Part II",    termin: '15 X 2018', status: 'PRYWATNE'},
    { id:4, orderId:3994, costomerName:"Pulp fiction",              termin: '23 X 2018', status: 'PRYWATNE'}
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
    data: gibon(prywatneZamowienia)   
};