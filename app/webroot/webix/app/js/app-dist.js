let listOfCustomers = { 
    id: "listOfCustomers",
    view:"datatable",
    select: true,
    ikonaKosza: "<span class='webix_icon fa-trash customers-kosz'></span>",
    css: "list-of-customers",
    //gravity: 1.3,    
    columns: [
        { id:"index", header:"Lp.", sort:"int", width:35, css:{'text-align':'right'} },
        //{ id:"WebixCustomer_id", header:"id", width:53, css:{'text-align':'right'} },
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
        if( listOfCustomers.postData.kosz ) { // Włączony => zkoloruj kosz
            theSpan.classList.add("customers-kosz");
            //console.log("adjustKosz ON");
        } else { // Wyłączony => "odkoloruj" kosz
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
    // Obsługa linków uploadu dla klienta
    parseChain: function(daneObj) {   
        
        //Stwórz puste dane do linków
        let i;
        for( i=0; i<globalAppData.config.maxUpLinks; i++) {
            daneObj["link" + i] = "";
        }
        // Nadpisz prawdziwymi linkami
        if( "WebixChain" in daneObj && daneObj.WebixChain.length ) {                       
            for( i=0; i<daneObj.WebixChain.length; i++ ) {
                daneObj["link" + i] =
                    daneObj.WebixChain[i].chain + "-" +
                    daneObj.WebixCustomerRealOwner_inic.toLowerCase() +
                    daneObj.WebixCustomer_id;
            }
        }
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
            Po kliknięciu w jakiegoś klienta na liscie, chcemy wyświetlić szczegóły dotyczące klienta */
        onAfterSelect: function(id){            
           
            // id klikniętego klienta w bazie
            let theCustomerId = $$(listOfCustomers.id).getItem(id).WebixCustomer_id; 
            //console.log(theCustomerId);
            let url = globalAppData.config.justOneCustomerData + theCustomerId + ".json";
            
            // pobierz świeże dane dot. tego klienta
            webix.ajax(url).then(function(data){   
                
                let dane = data.json();
                // Przygotuj linki, do uploadu plików                 
                $$(listOfCustomers.id).config.parseChain(dane);         
                if( !$$(customerPanel.id).isVisible() ) {                    
                    // Chowamy niektóre kolumny, bo mamy mniej miejsca
                    $$(listOfCustomers.id).config.hideTheColumns();                    
                    $$(customerPanel.id).show(); // Pokaż component ze szczegółami klienta i dod. mowego zam.                               
                    listOfCustomers.adjustKosz(); //Wyłącza się kosz, przy renderingu tabeli => więc poprawiamy
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

// Component do dodawania nowego szybkiego zamówienia

let customerName = {    
    template: globalAppData.template.theCustomerDetail1,
    height: 60
}

let addOrderAllTheRest_ = {   
    id: "addOrderAllTheRest_",
    template: " ",
    borderless:true
}

let theInputWidth = 380;
let formularz = {
    id:"formularz",
    view:"form", 
    //width: 270,
    elements:[
        {
            view: "select",
            name: "newcustomer",
            options: [
                { "id":"", "value": "- wybierz-"},
                { "id":"0", "value": "STAŁY"},
                { "id":"1", "value": "NOWY"}
            ],
            width: 100,
            //label: "Klient",            labelWidth: 50
        },
        //{view: "switch",width: 170,value: "1",name: "filelink",label: "Link dla klienta",labelWidth: 110},
        { view:"text", name:"email", placeholder:"e-mail", width: theInputWidth,
         align:"left", label: "Link do przesyłania plików zostanie wysłany na adres:",
         labelAlign: "left",
         labelPosition: "top"},  
        { view:"text", name:"nazwa_karty", placeholder:"Nazwa karty", width: theInputWidth,
         align:"left" },
        { view:"text", name:"ile", placeholder:"Ilość", width: 150,
         align:"left", attributes:{ type: "number", min: "1" } },  
         {
            view: "textarea",            
            width: theInputWidth,
            height: 150,
            name: "uwagi",
            placeholder: "Uwagi"
        },       
         {
            id: "submitButton",
            label: "Zapisz!",
            view: "button",             
            width: 120,
            name: "zapisz",
            hidden: true
         },
        {}
        
    ]
}

webix.ready(function(){
    /*
    $$(formularz.id).elements["newcustomer"].attachEvent("onChange", function(newv, oldv){
        //webix.message("Value changed from: "+oldv+" to: "+newv);
        if( newv == "0" || newv == "1" ) {
            //$$("submitButton").show();
            $$("allTheRest").removeView(addingNewOrderWidget.id);
            $$("allTheRest").addView(allThePrivateOrdersFullV2, 0);
        } else {
            $$("submitButton").hide();
        }   
    });
    */
   
    /*
    $$("submitButton").attachEvent("onItemClick", function(id, e){
        let url = "/webixOrders/quickOrderSave.json";
        //let postData = {"primo": "hau", "secundo":"miau"};
        let postData = $$(formularz.id).getValues();
        webix.ajax().post(url, postData).then(function(data) {
            let dane = data.json();                            
            console.log(dane);
            if( dane.result.success ) {   
                $$(formularz.id).clear();             
                webix.message({
                    type:"debug", text:"Zamówienie zostało zapisane!",
                    expire:7000
                });
            } else {                
                webix.message({
                    type:"error",
                    text:"Nie udało się zapisać zamówienia...",
                    expire:7000
                });
            }
        });
    });
*/

});

let addOrderAllTheRest = {
    id: "addOrderAllTheRest",
    //template: "a tu będzie reszta",
    cols: [
        formularz,
        { template: " ", borderless:true}
    ],
    hidden: true,
    borderless:true,
    css: "add-inside"
}


let addOrderNaglowek = {
    id: "addOrderNaglowek",    
    type: 'header', template: '<span>Nowe zamówienie</span>', hidden: true
}

let addNewQuickOrder = {     
    id: "addNewQuickOrder",
    css: "add-quick-order moj-naglowek",
    hidden: true,
    rows: [     
            addOrderNaglowek,
            {
                id: "customerName",
                template: " ",
                borderless:true,
                css: "add-inside klient-nazwa"
            },
            //formularz,
            addOrderAllTheRest,
            addOrderAllTheRest_ // taki wypełniacz
    ]
};
/**
 * Component zawierający szczegóły o wybranym kliencie */

let customerDetail = {
    id: "customerDetail",
    //gravity: 1.5,
    css: 'customer-detail',    
    template: globalAppData.template.theCustomerDetail3,      
    scroll:true 
    //"Tu będą szczegóły o kliencie<div>#WebixCustomer_name#</div>"
}
/**
 * Component zawierający szczegóły o wybranym kliencie
 * + możliwość dodania do niego zamówienia */

 let buttDl = 90;
 let customerDetailToolbar = {
     id: "customerDetailToolbar",
     view: "toolbar",
     gravity: 0.19,
     css: "customer-detail-toolbar",     
     elements: [
        //{ id:"btest5", view:"button", value:"Add", click: "sTCB"},        
        {   id: "more", view:"button", type:"icon", icon:"info-circle",
            css: "cd-button", click: "sTCB", width:buttDl},
        {},
        { id: "drop_generate", view:"button", type:"icon", icon:"link",
            css:"cd-button", click: "genrujDrop"},              
        { id:"cd_delete", view:"button", css: "cd-kosz cd-button",
            type:"icon", icon:"trash-o", badge:0, click: "sTCB", width:buttDl },
        {},
        { id:"closeIt", view:"button",  css: "cd-button",
            type:"icon", icon:"times", click: "sTCB", width:buttDl}
     ],
     obsluzKlikniecieBatona: function(idBatona) {
         
        // ID klienta
        let theId = $$(listOfCustomers.id).getSelectedItem().WebixCustomer_id;
        switch(idBatona) {
            case "closeIt":                
                // To samo jest w listOfCustomer.onAfterFilter => trzeba to jakoś w jeden kod zamienić
                if( $$(customerPanel.id).isVisible() ) {                    
                    $$(customerPanel.id).hide(); // Schowaj szczegóły klienta                    
                    $$(listOfCustomers.id).config.showTheColumns(); // Pokaż z powrotem schowane kolumny
                    $$(listOfCustomers.id).clearSelection();                 
                }
                break;   
            case "more":                                                
                window.open(globalAppData.config.customerUrl + theId, "_blank");
                break;  
            case "cd_delete": // usuwanie klienta
                webix.confirm({
                    title: "POTWIERDŹ USUNIĘCIE",// the text of the box header
                    text: "Klient oraz powiązane z nim dane - zamówienia, karty zostaną USUNIĘTE! Kontynuowć?",
                    ok: "Tak",
                    cancel: "NIE",
                    callback: function(okUsuwamy) { // true - kliknął YES
                        
                        if ( okUsuwamy ) { 
                            // użytkownik potwierdził usunięcie => więc usuwamy!
                            let delUrl = globalAppData.config.delCustomerUrl + theId + ".json";
                            webix.ajax(delUrl, function(text, data) {  // usuwamy klienta                  
                                $dl = text.search("err");
                                if( $dl >= 0 ) { // prawidłowa odpowiedź (w sensie jonson)
                                    console.log(data.json());
                                    if( !data.json().err ) { // skutecznie usunięty
                                        // Filtrujemy ponownie, by nam zniknął usunięty element                            
                                        $$(listOfCustomers.id).filterByAll();
                                        //let xyz = $$(listOfCustomers.id).getSelectedId(); webix.message("we ARE HERE! + " + xyz);                           
                                    }
                                } else {                        
                                    // zakładamay, że to oznacza brak zalogowoania
                                    window.open("/pulpit", "_self");
                                }
                            });
                        }                    
                    }
                });                
                break;
            default:
                webix.message(idBatona); 
        }     
     }
 }

 function genrujDrop() {

    webix.confirm({
        title: "POTWIERDŹ WYGENEROWANIE LINKU",// the text of the box header
        text: "Wygeneroować link dla tego klienta?",
        ok: "TAK",
        cancel: "NIE",
        callback: function(okGeneruj) { // true - kliknął YES
            
            if ( okGeneruj ) { 
                
            }                    
        }
    });  
 }

 // Wrap do customerDetailToolbar.obsluzKlikniecieBatona dla krótkości
 // czyli serveTheClickedButton
 function sTCB(buttonId) {    
    $$(customerDetailToolbar.id).config.obsluzKlikniecieBatona(buttonId);
 }

 let customerPanel = {
     id: "customerPanel",
     animate: {subtype:"in"},
     gravity: 0.8,
     hidden: true,
     css: "customer-panel",
     cells: [
        //{template: "Dummy", width: 100},
        {rows:[customerDetailToolbar, customerDetail]},
        addNewQuickOrder
     ]
 }
// Dane tabeli listOfPrivateOrders
let conf = {
    // Obiekt opisujący filter ludzików
    thePeopleFilterHeader: {content:'serverSelectFilter', options: []},
    theUserId: globalAppData.loggedInUser.id, // id użytkownika, którego zamówienia chcemy wyświetlić
}

//Definicja kolumn tabeli
let kolumny = [
    { id:"index", header:"", sort:"int", adjust:true },
    { id:"WebixPrivateOrder_id", header:"id", adjust:true },    
    { id: "WebixCustomer_name", header: "Klient",  fillspace:true },                
    { id: "WebixPrivateOrder_ileKart", header: "<span class='webix_icon fa-credit-card'></span>",  adjust: true  }, 
    { id: "WebixPrivateOrderOwner_name", header: [ conf.thePeopleFilterHeader ] , width:108 },        
    { id: "WebixPrivateOrder_stop_day", header:"Termin", adjust: true }        
];
// kontrolery zdarzeń dla listOfPrivateOrders

let onBeforeFilterHandler = function() {            
    conf.theUserId = this.getFilter("WebixPrivateOrderOwner_name").value;        
}

/**    
 * Problem: przy załadowaniu strony mamy filtr ustawiony na "Wszyscy", a ładują się dane dla
 * zalogowanego użytkownika (tak jak zresztą chcemy). Wykorzystujemy zdarzenie 'onAfterLoad',
 * by to skorygować. Warunek jest po to by ta korekcja zachodziła tylko przy pierwszej inicjalizacji
 * (tylko wtedy warunek jest spełniony). Być może istnieje lepszy sposób ustawienia filtra czy coś.
 */
let onAfterLoadHandler = function(){   
    /* Dajemy warunek, bo jeżeli po załadowaniu komponent jest niewidoczny,
    to sprawdzanie filtra nie działa (albo nie ma sensu po prostu)  */
    if ($$(managePrivateOrders.id).isVisible() ) {
        if( this.getFilter("WebixPrivateOrderOwner_name").value != conf.theUserId ) {                
            this.getFilter("WebixPrivateOrderOwner_name").value = conf.theUserId;
        }
        // po zmianie filtra (wybrany inny handlowiec), czyścimy listę kart i chowamy tabelkę
        $$(listOfCards.id).clearAll(true);
        $$(listOfCards.id).hide();

        // czyscimy component ze szczegółami zamówienia    
        $$(theOrderDetail.id).define("template", "");
        $$(theOrderDetail.id).refresh();
    }
}

let onAfterSelectHandler = function(id){ 
        
   $$(listOfCards.id).show();
   // czyścimy listę kart, by nowe zastąpiły a nie dołączały się
   $$(listOfCards.id).clearAll(true);

    // Przygotuj prawidłowy url ( z id zamówienia w bazie)
    let url =   "webixOrders/getOneOrderLight/" +                
                $$(listOfPrivateOrders.id).getItem(id).WebixPrivateOrder_id + // <= id tego zamówienia w bazie SKP
                ".json";
    // pobierz świeże dane dot. tego zamówienia
    webix.ajax(url).then(function(data){   
        let dane = data.json();  //console.log(dane);
        if( dane.WebixOrder_ileKart ) { // Jeżeli są jakieś karty                                        
            $$(listOfCards.id).parse(dane.WebixCard); // karty tego zamówienia
        }
        /* Tworzymy template ze szczegółami zamówienia (bo nie hcemy by nam się cokolwiek wyświetlało,
            jak nie ma danych) */        
        $$(theOrderDetail.id).define("template", globalAppData.template.theOrderDetail);
        $$(theOrderDetail.id).parse({
            id: dane.WebixOrder_id,
            termin: dane.WebixOrder_stop_day
        });
    });                               
}
let listOfCards = {
    id: "listOfCards",
    view: "datatable",    hidden: true,
    //gravity: 0.5,    
    columns: [
        { id:"index", header:"", sort:"int", width:35 },
        { id:"id", header:"id", width:60 },
        { id:"name", header:"Nazwa karty", fillspace:true },
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    }
};
let theOrderDetail = {
    id: "theOrderDetail",
    view: "template",
    css: "theOrderDetail", // na razie nie używam - tak testowo
    // Zaczynamy bez zdefiniowanej template, bedzie uaktualniona, po kliknieciu w rekord        
    gravity: 1
}
let privateOrdersUrlHandler = function(){ // Dokumentacja: https://docs.webix.com/desktop__server_customload.html
    let url = "webixPrivateOrders/getTheOrders/" + conf.theUserId + ".json";
    return webix.ajax(url).then(function(data){
        if( data.text().search("records") >= 0 ) { 
            // powinno być, jeżeli dostaniemy prawidłowy json - PRZETWARZAMY 
            let dane = data.json();                
            // Lidziki aktualnie mający prywatne zamówienia
            conf.thePeopleFilterHeader.options = dane.peopleHavingPrivs;
            return dane.records;  //w records mamy faktyczne dane                            
        }          
        return [];    
    });
}

let listOfPrivateOrders = {
    id: "listOfPrivateOrders",
    view:"datatable",
    select: true, // umożliwia selekcję
    gravity: 1.7,    
    //theUserId: globalAppData.loggedInUser.id, // id użytkownika, którego zamówienia chcemy wyświetlić
    columns: kolumny,
    scheme: {
        $init:function(obj){ obj.index = this.count(); }
    },    
    url: privateOrdersUrlHandler,    
    on: {
        'onBeforeFilter': onBeforeFilterHandler,      
        'onAfterLoad': onAfterLoadHandler,
        'onAfterSelect': onAfterSelectHandler
    }
}

let managePrivateOrders = {
    id: "managePrivateOrders",
    padding: globalAppData.config.wyglad.mainPad, //35,
    type:"space",
    //rows: testContent1    
    css: "moj-naglowek",
    cols: [
        listOfPrivateOrders,
        {gravity: 0.01},// taki spacer  
        {
            rows: [                
                theOrderDetail,
                listOfCards
            ]                    
        }
    ]
}
let manageCustomers = {
    id: "manageCustomers",
    padding: globalAppData.config.wyglad.mainPad, //35,
    type:"space",      
    cols: [
        listOfCustomers,
        customerPanel
    ]
}

// Menu w głównym pasku narzedziowym
let toolbarMenu = {
    id: "toolbarMenu",
    view:"menu",    
    data: [ // elementy menu
        // whereToGo posiada informację, gdzie ten item przełącza
        {   id: "klienci", value:"Klienci", icon: "address-book-o",
            whereToGo: manageCustomers.id },/**/
        {   id: "prywatne", value:"Prywatne", icon: "handshake-o",
            whereToGo: "managePrivateOrders" }
            
    ],
    css: "toolbar-menu",
    ready: function(){ // Zakoloruj odpowiedni element menu    
        $$(toolbarMenu.id).disableItem("klienci");
    },
    on:{
        /* Po kliknięciu w elem. menu aktywujemy go (używając webix'owego disablowania)
        i ładujemy odpowiedni komponent "podpięty" do tego menu */
        onMenuItemClick:function(id){            
            // ... whereToGo zawiera informację gdzie trzeba przełączyć
            $$(this.getMenuItem(id).whereToGo).show();
            $$(toolbarMenu.id).config.data.forEach(function(menuItem){
                // "Zinabluj" kazdy element menu
                $$(toolbarMenu.id).enableItem(menuItem.id); 
            });
            $$(toolbarMenu.id).disableItem(id);
        }
    }
}
//Top toolbar

let userInfo = { 
    view:"button", type:"icon", icon:"user",
    label: globalAppData.loggedInUser.name, // Tu leci Imię zalogowanego użytkownika
    width: 110, id:'userInfoToolbar',
    css:'kwa-mia-hau',    // w celach testowych
    //click: logoutHandler  <= w taki sposób, jeżeli chcemy użyć osobnej funkcji
    click: function (){ window.open(globalAppData.config.logoutUrl, "_self"); }
}
// takie testowe było { view: "button", type: "icon", value: "Zosia", width: 65, css: "app_button", icon: "user-o",  badge:"Darek"};

let mainToolbar = {
    responsive: true,
    view: "toolbar", padding:3,
    elements: [
        /*
        { view: "button", type: "icon", icon: "bars",
            width: 37, align: "left", css: "app_button", click: function(){
                $$("lewy-sidebar").toggle();
            }
        },
        */
        { view: "label", label: " ", width: 68},
        //toolbarMenu,        
        
        //toggleSwitch,
        {},
        userInfo
        //,{ view: "button", type: "icon", width: 45, css: "app_button", icon: "envelope-o",  badge:4},
        //{ view: "button", type: "icon", width: 45, css: "app_button", icon: "bell-o",  badge:10}
    ]
};






let menu_data = [
    {id: "side-klienci", icon: "address-book-o", value: "Klienci",  data:[
        { id: "side-klienci-list", value: '<i class="fa fa-list" aria-hidden="true"></i> Lista' },
        { id: "side-klienci-add", value: '<i class="fa fa-plus" aria-hidden="true"></i> Dodaj'}
    ]},
    {id: "side-karty", icon: "credit-card", value:"Karty", data:[
        { id: "side-karty-list", value: '<i class="fa fa-list" aria-hidden="true"></i> Lista'},
        { id: "side-karty-add", value: '<i class="fa fa-plus" aria-hidden="true"></i> Dodaj'}
    ]},
    {id: "side-handlowe", icon: "handshake-o", value:"Handlowe", data:[
        { id: "side-handlowe-list", value: '<i class="fa fa-list" aria-hidden="true"></i> Lista'},
        { id: "side-handlowe-add", value: '<i class="fa fa-plus" aria-hidden="true"></i> Dodaj'}
    ]},
    {id: "side-produkcyjne", icon: "industry", value:"Produkcyjne", data:[
        { id: "side-produkcyjne-list", value: '<i class="fa fa-list" aria-hidden="true"></i> Lista'},
        { id: "side-produkcyjne-add", value: '<i class="fa fa-plus" aria-hidden="true"></i> Dodaj'}
    ]}    
];

let leftSidebar = {
    view: "sidebar",
    id: "lewy-sidebar",
    data: menu_data,
    collapsed: true,
    on: {
            onAfterSelect: function(id){
                
                let where, act=true;
                switch(id) {
                    case "side-klienci-list":
                        where = "customers";
                        break;
                    case "side-klienci-add":
                        where = "customers/add";
                        break;
                    case "side-karty-list":
                        where = "cards";
                        break;
                    case "side-karty-add":
                        where = "cards/add";
                        break;
                    case "side-handlowe-list":
                        where = "orders";
                        break;
                    case "side-handlowe-add":
                        where = "orders/add";
                        break;
                    case "side-produkcyjne-list":
                        where = "jobs";
                        break;
                    case "side-produkcyjne-add":
                        where = "jobs/add";
                        break;
                    default:
                        act = false;
                }
                if( act ) {
                    window.open(where, "_self");
                }                
            }
    }
};
/*
click:function(){
    window.open("<a target='_blank' href='http://docs.webix.com'>Webix Docs</a>");
}
*/

/* Ikony zagnieżdżone też działają, ale jak sidebar nie jest collapsed

https://snippet.webix.com/z60bmqjk

var menu_data_multi  = [
    { id: "structure", icon: "columns", value:"Structuring", data:[
      { id: "layouts", icon:"circle", value:"Layouts", data:[
        { id: "layout", icon:"circle-o", value: "Layout"},
        { id: "flexlayout", icon:"circle-o", value: "Flex Layout"},
        { id:"strict", icon:"circle-o", value:"Precise Positioning", data:[
          { id: "gridlayout", icon:"circle-o", value: "Grid Layoot"},
          { id: "dashboard",  icon:"circle-o", value: "Dashboard"},
          { id: "abslayout", icon:"circle-o", value: "Abs Layout"}
        ]},
        { id: "datalayouts", icon:"circle-o", value:"Data Layouts",  data:[
          { id: "datalayout", icon:"circle-o", value: "Data Layout"},
          { id: "flexdatalayout",  icon:"circle-o", value: "Flex Data Layout"},
        ]}
      ]},
      {id: "multiviews", icon:"circle", value:"Multiviews", data:[
        { id: "multiview", icon:"circle-o", value: "MultiView"},
        { id: "tabview",  icon:"circle-o", value: "TabView"},
        { id: "accordion",  icon:"circle-o", value: "Accordion"},
        { id: "carousel", icon:"circle-o", value: "Casousel"}
      ]}
    ]},
    {id: "tools", icon: "calendar-o", value:"Tools", data:[
      { id: "kanban", icon:"circle", value: "Kanban Board"},
      { id: "pivot", icon:"circle", value: "Pivot Chart"},
      { id: "scheduler", icon:"circle", value: "Calendar"}
    ]},
    {id: "forms", icon: "pencil-square-o", value:"Forms",  data:[
      {id: "buttons", icon:"circle", value: "Buttons", data:[
        {id: "button", icon:"circle-o", value: "Buttons"},
        {id: "segmented", icon:"circle-o", value: "Segmented"},
        {id: "toggle", icon:"circle-o", value: "Toggle"},
      ]},
      { id:"texts", icon:"circle", value:"Text Fields", data:[
        { id: "text", icon:"circle-o", value: "Text"},
        { id: "textarea", icon:"circle-o", value: "Textarea"},
        { id: "richtext", icon:"circle-o", value: "RichText"}
      ]},
      { id:"selects", icon:"circle", value:"Selectors", data:[
        { id:"single", icon:"circle-o", value:"Single value", data:[
          { id: "combo", icon:"circle-o", value: "Combo"},
          { id: "richselect", icon:"circle-o", value: "RichSelect"},
          { id: "select", icon:"circle-o", value: "Select"}
        ]},
        { id:"multi", icon:"circle-o", value:"Multiple values", data:[
          { id: "multicombo", icon:"circle-o", value: "MultiCombo"},
          { id: "multiselect", icon:"circle-o", value: "MultiSelect"}
        ]}
      ]}
    ]},
    {id: "demo", icon: "book", value:"Documentation"}
  ];
*/
// Tu po nowemu cała zawartość
let animacja = {
    a: { direction:"top"},
    b: { type:"flip"},
    c: { type:"flip", subtype:"vertical"}, 
    d: {subtype:"out"},    
    e: {subtype:"in"},
    f: false 
}

let content = {
    id: "content",    
    animate: animacja.d
    ,cells: [  
        manageCustomers,      
        //manageAddingQuickOrder,
        managePrivateOrders
    ]
}
//@prepros-prepend ./content/customers/listOfCustomers.js
//@prepros-prepend ./content/orders/addNewQuickOrder.js
//@prepros-prepend ./content/customers/customerDetail.js
//@prepros-prepend ./content/customers/customerPanel.js
//@prepros-prepend ./content/orders/privateOrders/conf.js
//@prepros-prepend ./content/orders/privateOrders/eventsHandlers.js
//@prepros-prepend ./content/orders/theOrderDetail/listOfCards.js
//@prepros-prepend ./content/orders/theOrderDetail/theOrderDetail.js
//@prepros-prepend ./content/orders/privateOrders/listOfPrivateOrders.js
//@prepros-prepend ./content/orders/managePrivateOrders.js                  
//@prepros-prepend ./content/customers/manageCustomers.js 
//@prepros-prepend ./layout/toolbarMenu.js
//@prepros-prepend ./layout/mainToolbar.js
//@prepros-prepend ./layout/leftSidebar.js                
//@prepros-prepend ./layout/content.js

/**
 * Główny plik js */
webix.ready(function(){ //to ensure that your code is executed after the page is fully loaded
  
    let layout = {
        id: "theLayout", 
        css: 'app-main',
        rows:[
            mainToolbar,
            { 
                cols:[
                    leftSidebar,
                    content// zawartość
                ]
            }             
        ]   
    }    

    webix.ui(
        layout 
    );

});

//# sourceMappingURL=app-dist.js.map