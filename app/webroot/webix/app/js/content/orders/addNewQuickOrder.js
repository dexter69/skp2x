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