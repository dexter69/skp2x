let manageAddingQuickOrder = {
    id: "manageAddingQuickOrder",
    rows: [
        {            
            view: "button",
            label: "Przełącz!",                         
            width: 120,
            on: {
                'onItemClick': function(){
                    //console.log("kliknęli 2!");
                    $$(managePrivateOrders.id).show();
                }
            }       
         },
         {template: "Zarządzanie dodawaniem nowego zamówienia"}
    ]    
}