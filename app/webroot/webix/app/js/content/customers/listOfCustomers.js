let listOfCustomers = { 
    id: "listOfCustomers",
    view:"datatable",
    select: true,
    ikonaKosza: "<span class='webix_icon fa-trash customers-kosz'></span>",
    css: "list-of-customers",
    //gravity: 1.3,    
    columns: [        
        { id:"index", header:"", sort:"int", width:35, css:{'text-align':'right'} },        
        { id:"WebixCustomerRealOwner_name", header: [ {content:"serverSelectFilter", options: globalAppData.customerOwners }], width:108},
        { id:"WebixCustomer_id", header:"id", width:53, css:{'text-align':'right'} },
        { id:"WebixCustomer_name", header:[ {content:"serverFilter"}], fillspace:true }, 
        { id:"WebixCustomer_kosz", header:"<span class='webix_icon fa-trash'></span>", width:40, css:{'text-align':'center'} },
        { id:"WebixAdresSiedziby_miasto", header:"Miasto", adjust:true},        
        { id:"WebixCustomer_ulica_nr", header:"Ulica, numer", adjust:true}        
    ],  
    // Te chowamy, gdy chcemy mieć węższą tabelę
    meant2hide: ["WebixAdresSiedziby_miasto", "WebixCustomer_ulica_nr"]  ,
    hideTheColumns: function(){                 
        this.meant2hide.forEach(function(idKolumny){
            $$(listOfCustomers.id).hideColumn(idKolumny);
        });
    },
    showTheColumns: function(){ 
        this.meant2hide.forEach(function(idKolumny){
            $$(listOfCustomers.id).showColumn(idKolumny);
        });
    },
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    }, 
    //globalAppData.config.customersAddOrder
    postData: { // początkowe parametry do zapytania do serwera
        fraza: '',
        realOwnerId: globalAppData.loggedInUser.id
    },
    url: function(){
        let url = globalAppData.config.customersAddOrder;                
        if( globalAppData.loggedInUser.id == listOfCustomers.postData.realOwnerId && loggedUserInHasNoAnyCustomer() ) {
            listOfCustomers.postData.realOwnerId = 0;
        }
        return webix.ajax().post(url, listOfCustomers.postData).then(function(data) {
            let dane = data.json();              
            dane.records.forEach(function(record){
                // Kompilujemy część adresu
                record.WebixCustomer_ulica_nr = `${record.WebixAdresSiedziby_ulica} ${record.WebixAdresSiedziby_nr_budynku}`;
                if( record.WebixCustomer_howManyNonPrivateOrders == 0 ) { // jeżeli nie ma NIE prywatnych
                    // to dodajemy ikonkę kosza                
                    record["WebixCustomer_kosz"] = listOfCustomers.ikonaKosza;
                }                 
            });                      
            return dane.records;  // w records mamy faktyczne dane                            
        });
    },    
    on: {     
        onAfterFilter:function(){
            //webix.message("Filtr!");
            if( $$(customerPanel.id).isVisible() ) {
                // Schowaj szczegóły klienta, bo wiersz w tabeli został "odzaznaczony"
                $$(customerPanel.id).hide();
                // I pokazujemy z powrotem kolumny, które wcześniej schowaliśmy
                $$(listOfCustomers.id).config.showTheColumns();
                //this.getFilter("WebixCustomer_name").focus();
            }
            this.getFilter("WebixCustomer_name").focus();
          },    
        //onAfterUnSelect: function(){ webix.message("ODznaczone!");},
        // Pobieramy zawartości filtrów, dzięki czemu Webix wykona zapytanie z odpowiednimi parametrami
        'onBeforeFilter': function() {            
            listOfCustomers.postData.realOwnerId = this.getFilter("WebixCustomerRealOwner_name").value;
            listOfCustomers.postData.fraza = this.getFilter("WebixCustomer_name").value;
        },
        // Nie wiem czy w ogóle to ma sens. Gdy nie jest widoczny, to nie ma sensu - dosta-
        //  jemy błąd (stąd warunek tu). Zostawiam jednak, bo może zmienimy zdanie
        //  i ten komponent bedzie najpierw widoczny - wówczas moze się przydać
        'onAfterLoad': function(){
            if( $$(manageCustomers.id).isVisible() && //sprawdzanie filtra na niewidocznym nie ma sensu
                this.getFilter("WebixCustomerRealOwner_name").value != listOfCustomers.postData.realOwnerId) { // i filter nie jest OK           
                this.getFilter("WebixCustomerRealOwner_name").value = listOfCustomers.postData.realOwnerId;            
            }
            //Taki workaround, bo po przerysowaniu pole traci fokus
            this.getFilter("WebixCustomer_name").focus();
            //webix.message("Load");
        },
        /**
            Po kliknięciu w jakiegoś klienta na liscie, chcemy wyświetlić formularz do dodwania szybkiego
            zamówienia */
        'onAfterSelect': function(id){ 
            //webix.message("ZAZNACZONE!");
            //$$(listOfCustomers.id).config.hideTheColumns();
            //console.log($$(listOfCustomers.id).getItem(id));
            // Przemaluj komponent/y                  
            //webix.message("kliknięte!");   
            
            /* to na razie wyłączam - działało dobrze z dodawaniem zamówienia
            $$("customerName").define(customerName);  // nie musimy refresh, bo pozniej parse załatwi sprawę
            $$("addOrderNaglowek").show();            
            $$("addOrderAllTheRest_").hide();
            $$("addOrderAllTheRest").show();
            */

            // id klikniętego klienta w bazie
            let theCustomerId = $$(listOfCustomers.id).getItem(id).WebixCustomer_id; 
            //console.log(theCustomerId);
            let url = globalAppData.config.justOneCustomerData + theCustomerId + ".json";

            // pobierz świeże dane dot. tego klienta
            webix.ajax(url).then(function(data){   
                let dane = data.json();   
                if( !$$(customerPanel.id).isVisible() ) {
                    // Chowamy niektóre kolumny, bo mamy mniej miejsca
                    $$(listOfCustomers.id).config.hideTheColumns();                    
                    $$(customerPanel.id).show(); // Pokaż component ze szczegółami klienta i dod. mowego zam.                    
                }                
                //console.log(dane);
                $$("customerName").parse(dane);
                $$(formularz.id).setValues({
                    email: dane.WebixCustomer_email
                });
            });            
        }
    }
}

/**
    Sprawdzamy, czy zalogowany użytkownik ma pod opieką klientów */
function loggedUserInHasNoAnyCustomer() {
    let i;
    for (i = 0; i < globalAppData.customerOwners.length; i++) { 
        if( globalAppData.customerOwners[i].id == globalAppData.loggedInUser.id ) {
            return false;
        }
    }
    return true;    
}

