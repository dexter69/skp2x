let privateOrdersUrlHandler = function(){ // Dokumentacja: https://docs.webix.com/desktop__server_customload.html
    let url = "webixPrivateOrders/getTheOrders/" + conf.theUserId + ".json";
    return webix.ajax(url).then(function(data){
        let dane = data.json();                
        // Lidziki aktualnie mający prywatne zamówienia
        conf.thePeopleFilterHeader.options = dane.peopleHavingPrivs;
        return dane.records;  // w records mamy faktyczne dane                            
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