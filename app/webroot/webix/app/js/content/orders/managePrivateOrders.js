let managePrivateOrders = {
    id: "managePrivateOrders",
    rows: [
        {
            view: "button",
            label: "Przełącz!",                         
            width: 120,
            on: {
                'onItemClick': function(){
                    //console.log("kliknęli!");
                    $$(manageAddingQuickOrder.id).show();
                }
            }          
         },
         {template: "Zarządzanie prywatnymi zamówieniami"}
    ]
    
}