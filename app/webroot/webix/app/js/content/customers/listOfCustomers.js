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
        { id:"WebixCustomerRealOwner_name", header: [ {content:"serverSelectFilter", options: globalAppData.customerOwners }], width:108}
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