// Component do dodawania nowego szybkiego zamówienia

let customerName = {    
    template: globalAppData.template.theCustomerDetail1
}

let addOrderAllTheRest = {
    template: "a tu będzie reszta"
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
            {   
                id: "addOrderAllTheRest",
                template: " ",
                borderless:true,
                css: "add-inside"
            }
    ]
};