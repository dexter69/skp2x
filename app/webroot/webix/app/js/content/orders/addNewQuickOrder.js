// Component do dodawania nowego szybkiego zamówienia

let customerName = {
    template: "<label>klient:</label><div>#WebixCustomer_name#</div>"
}

let addOrderAllTheRest = {
    template: "a tu będzie reszta"
}

let addNewQuickOrder = {     
    id: "addNewQuickOrder",
    rows: [     
            {
                id: "customerName",
                template: " ",
                borderless:true
            },
            {   
                id: "addOrderAllTheRest",
                template: " ",
                borderless:true
            }
    ]
};