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

let datePicker = {
    view: "datepicker",
    //left: 0,            top: 0,
    //width: 200,
    placeholder: "Termin",
    //name: "datka",
    format: "%d-%m-%Y",
    //gravity: 0.8
}

let addOrderAllTheRest = {
    id: "addOrderAllTheRest",
    //template: "a tu będzie reszta",
    hidden: true,
    borderless:true,
    css: "add-inside",
    rows: [
        {cols: [
                datePicker,
                {}
            ]
        },        
        {template: "2222222222222"}
    ]
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