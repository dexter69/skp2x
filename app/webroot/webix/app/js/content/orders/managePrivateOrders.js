let testContent1 = [
    {
        view: "button",
        label: "NAPZRÓD !!!",                         
        //width: 120,
        on: {
            'onItemClick': function(){
                //console.log("kliknęli!");
                $$(manageAddingQuickOrder.id).show();
            }
        }          
     },
     {template: "Zarządzanie prywatnymi zamówieniami"}
];

let guzik = { 
    view: "button",
    type: "icon",
    icon: "bars",
    width: 28,
    align: "center", // nie działa, więc chyba nie jest od tego
    //css: "app_button",    
    click: function(){ $$(manageAddingQuickOrder.id).show(); }
    
}

let managePrivateOrders = {
    id: "managePrivateOrders",
    padding:35, type:"space",
    //rows: testContent1    
    css: "moj-naglowek",
    cols: [
        listOfPrivateOrders,
        {gravity: 0.01},// taki spacer  
        {
            rows: [
                //{ type: 'header', template: '<span>Hau, Miau</span>'},
                {
                    view: "toolbar",
                    responsive: true,
                    elements: [
                        {},
                        guzik                        
                    ]
                },
                theOrderDetail,
                listOfCards
            ]                    
        }
    ]
}