let optionsViaCustomerOwners = [
    {id: 0, value: "Opiekun"},    
    {id: 3, value: "Agnieszka"},
    {id: 17, value: "Ania"},
    {id: 2, value: "Beata"},
    {id: 4, value: "Jola"},
    {id: 11, value: "Marzena"},
    {id: 31, value: "Piotr"},
    {id: 10, value: "Renata"}            
];

let listOfCustomers = { 
    id: "listOfCustomers",
    view:"datatable",
    select: true,
    gravity: 1.3,
    postData: { // początkowe parametry do zapytania do serwera
        fraza: '',
        realOwnerId: 0
    },
    columns: [
        { id:"index", header:"", sort:"int", width:35 },
        { id:"WebixCustomer_id", header:"id", width:50 },
        { id:"WebixCustomer_name", header:[ {content:"serverFilter"}], fillspace:true }, 
        { id:"WebixCustomerRealOwner_name", header: [ {content:"serverSelectFilter", options: optionsViaCustomerOwners }], width:108}
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    }, 
    //globalAppData.config.customersAddOrder
    url: function(){
        let url = globalAppData.config.customersAddOrder;        
        return webix.ajax().post(url, listOfCustomers.postData).then(function(data) {
            let dane = data.json();                            
            return dane.records;  // w records mamy faktyczne dane                            
        });
    },
    on: { // Pobieramy zawartości filtrów, dzięki czemu Webix wykona zapytanie z odpowiednimi parametrami
        'onBeforeFilter': function() {            
            listOfCustomers.postData.realOwnerId = this.getFilter("WebixCustomerRealOwner_name").value;
            listOfCustomers.postData.fraza = this.getFilter("WebixCustomer_name").value;
        }
    }
}