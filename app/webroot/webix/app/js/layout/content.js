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