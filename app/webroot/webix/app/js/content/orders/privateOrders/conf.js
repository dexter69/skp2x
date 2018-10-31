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