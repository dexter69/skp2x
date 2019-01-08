let listOfCustomers = { 
    id: "listOfCustomers",
    view:"datatable",
    select: true,
    ikonaKosza: "<span class='webix_icon fa-trash customers-kosz'></span>",
    css: "list-of-customers",
    //gravity: 1.3,    
    columns: [
        { id:"index", header:"", sort:"int", width:35, css:{'text-align':'right'} },
        { id:"WebixCustomer_id", header:"id", width:53, css:{'text-align':'right'} },
        //{ id:"WebixCustomer_kosz", header:"<input type='text' id='fakeInput'><span class='webix_icon fa-trash'></span>", width:/*40*/250, css:{'text-align':'center'} },
        { id:"WebixCustomer_kosz", header:{ css:"trashHeader", text:"<span id='trashHeaderSpan' class='webix_icon fa-trash'></span>" }, width:40, css:{'text-align':'center'} },
        { id:"WebixCustomer_name", header:[ {content:"serverFilter"}], fillspace:true },         
        { id:"WebixAdresSiedziby_miasto", header:"Miasto", adjust:true},        
        { id:"WebixCustomer_ulica_nr", header:"Ulica, numer", adjust:true},
        
        { id:"WebixCustomerRealOwner_name", header: [ {content:"serverSelectFilter", options: globalAppData.customerOwners }], width:108}
    ], 
    onClick:{ // Obsługa kliknięcia w kosz w nagłówku kolumny => filtrujemy koszaste!
        trashHeader : function() { 
            // To takie toggle parametru post data po kliknieciu 
            listOfCustomers.postData.kosz = !listOfCustomers.postData.kosz; 
            // I uaktualnienie wyglądu
            listOfCustomers.adjustKosz();
            $$(listOfCustomers.id).filterByAll(); // i wyzwalamay zapytanie do serwera                 
        }
    }, 
    // Uaktualniamy wygląd kosza w zależności od wartości listOfCustomers.postData.kosz
    adjustKosz: function(){         
        let theSpan = document.getElementById("trashHeaderSpan"); 
        if( listOfCustomers.postData.kosz ) { // Włącz kosz
            theSpan.classList.add("customers-kosz");
            //console.log("adjustKosz ON");
        } else { // Wyłącz kosz
            theSpan.classList.remove("customers-kosz");
            //console.log("adjustKosz OFF");
        }
    },
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
        realOwnerId: globalAppData.loggedInUser.id,
        limit: globalAppData.config.customersHowMany,
        kosz: false // tylko zamówienia, które można usunąć
    },
    url: function(){
        let url = globalAppData.config.customersGetMany;                
        if( globalAppData.loggedInUser.id == listOfCustomers.postData.realOwnerId && loggedUserInHasNoAnyCustomer() ) {
            listOfCustomers.postData.realOwnerId = 0;
        }
        let theResponse = webix.ajax().post(url, listOfCustomers.postData);
        return theResponse.then(function(data) {            
            //console.log(data.text().search("<!DOCTYPE html>")); console.log( data.text().search("records"));webix.message("We are here!!*************");  
            if( data.text().search("records") >= 0 ) { 
                console.log("Here!");
                // powinno być, jeżeli dostaniemy prawidłowy json - PRZETWARZAMY                
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
            } else {
                console.log("There!");
                //console.log(data.text());
                /* zakładamy, ze dostaliśmy html -> stronę logowania,
                    dlatego musimy przekierować na logowanie */
                //webix.message("TRZA PRZEKIWROAĆ"); console.log("TRZA PRZEKIWROAĆ");
                window.open("/pulpit", "_self");                
            }
        });
        /*
        .fail(function(err){
            webix.message("Fail in listOfCustomers");
            console.log(err);
        });
        */        
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
            listOfCustomers.adjustKosz();
          },    
        //onAfterUnSelect: function(){ webix.message("ODznaczone!");},
        // Pobieramy zawartości filtrów, dzięki czemu Webix wykona zapytanie z odpowiednimi parametrami
        onBeforeFilter: function() {            
            listOfCustomers.postData.realOwnerId = this.getFilter("WebixCustomerRealOwner_name").value;
            listOfCustomers.postData.fraza = this.getFilter("WebixCustomer_name").value;
        },
        // Nie wiem czy w ogóle to ma sens. Gdy nie jest widoczny, to nie ma sensu - dosta-
        //  jemy błąd (stąd warunek tu). Zostawiam jednak, bo może zmienimy zdanie
        //  i ten komponent bedzie najpierw widoczny - wówczas moze się przydać
        onAfterLoad: function(){
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
        onAfterSelect: function(id){             
           
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
                if( dane.WebixCustomer_howManyNonPrivateOrders == 0 ) {
                    /* Czyli jeżeli nie mamy zamówień poza prywatnymi => można usuwać */ 
                    
                    // Wpisz do badge'a ilość prywtnych zamówień
                    $$("cd_delete").config.badge = "" + dane.WebixCustomer_howManyPrivateOrders;                     
                    $$("cd_delete").refresh(); // by uaktualnić wyświetlanie ilości prywatnych
                    $$("cd_delete").show(); // Pokaż kosz              
                } else { // Są jakieś NIE prywatne zamówienia, nie można usuwać
                    $$("cd_delete").hide(); // Ukryj kosz
                }                 
                if( dane.WebixCustomer_comment.length ) { // Jeżeli coś w komentarzu mamy
                    //Wzbogać dana => trick do wyświtlania takiego jak chcemy
                    //dane.WebixCustomer_comment = '<div class="cdetails-comment">' + dane.WebixCustomer_comment + "</div>";
                    dane.WebixCustomer_comment = `<div class="cdetails-comment">${dane.WebixCustomer_comment}</div>"`;                    
                } 
                $$(customerDetail.id).parse(dane);              
                //console.log(dane);
                /* Do czego to?
                $$("customerName").parse(dane);
                $$(formularz.id).setValues({
                    email: dane.WebixCustomer_email
                });
                */
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
