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

let toggleSwitch = { // Używamy do przełączania głównych komponentów
    view:"toggle", type:"icon", name:"s4", 
    width: 172,
    //offIcon:"plus",  onIcon:"bars",
    //offLabel:"DODAJ ZAMÓWIENIE", onLabel:"LISTA PRYWATNYCH",
    css: "stearing-butt-in-toolbar",
    //,tooltip: "Testujemy tooltip"
    on: {
        "onChange": function(newv, /*oldv*/){  
            console.log("Odpaliło mnie!");          
            if( newv ) { // stan ON, czyli dla nas wyśw. nowe zam.                
                $$(manageAddingQuickOrder.id).show();
                /*  Poprawiamy ustawienie filtra przy pokazaniu się elementu, gdyż
                    po pierwszej inicjalizacji może nie być prawidłowy, a gdy jest ukryty,
                    to (prawdopodobnie) nie jest to mozliwe*/
                if(
                    $$(listOfCustomers.id).getFilter("WebixCustomerRealOwner_name").value !=
                    listOfCustomers.postData.realOwnerId ) {
                        $$(listOfCustomers.id).getFilter("WebixCustomerRealOwner_name").value = listOfCustomers.postData.realOwnerId;
                }
            } else {                
                $$(managePrivateOrders.id).show();
            }
        }
    }
}

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
        toolbarMenu,        
        
        //toggleSwitch,
        {},
        userInfo
        //,{ view: "button", type: "icon", width: 45, css: "app_button", icon: "envelope-o",  badge:4},
        //{ view: "button", type: "icon", width: 45, css: "app_button", icon: "bell-o",  badge:10}
    ]
};





