let listOfCustomers = { 
    id: "listOfCustomers",
    view:"datatable",
    select: true,
    gravity: 1.3,
    postData: { // początkowe parametry do zapytania do serwera
        fraza: '',
        realOwnerId: function() {
            if( listOfCustomers.checkIt() ) { // zalogowany użytkownik ma pod opieką klientów
                return globalAppData.loggedInUser.id;
            }
            return 0;
        }
    },
    columns: [
        { id:"index", header:"", sort:"int", width:35, css:{'text-align':'right'} },
        { id:"WebixCustomer_id", header:"id", width:53, css:{'text-align':'right'} },
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
        },
        // na wzór privateOrders
        'onAfterLoad': function(){   
            // Czy zalogowany użytkownik jest w ogóle w filtrze - bo jezeli nie
            if ( listOfCustomers.checkIt() ) {
                console.log('has ' + globalAppData.loggedInUser.id);
                listOfCustomers.postData.realOwnerId = globalAppData.loggedInUser.id;
                if( this.getFilter("WebixCustomerRealOwner_name").value != globalAppData.loggedInUser.id ) {                
                    this.getFilter("WebixCustomerRealOwner_name").value = globalAppData.loggedInUser.id;
                }

            } else {
                console.log("Nie ma");
            }
        }
    },
    /**
     *  Sprawdza, czy zalogowany użytkownik znajduje się na globalnej liście Handlowców,
     *  którzy posiadają pod opieką klientów */     
    checkIt: function() {

        let i;
        for (i = 0; i < globalAppData.customerOwners.length; i++) { 
            if( globalAppData.customerOwners[i].id == globalAppData.loggedInUser.id ) {
                return true;
            }
        }
        return false;
    }
}

