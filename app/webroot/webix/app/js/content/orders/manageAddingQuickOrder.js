let testContent2 = [
    {            
        view: "button",
        label: "W TYŁ !!!",                         
        //width: 120,
        on: {
            'onItemClick': function(){
                //console.log("kliknęli 2!");
                $$(managePrivateOrders.id).show();
            }
        }       
     },
     {template: "Zarządzanie dodawaniem nowego zamówienia"}
];

let manageAddingQuickOrder = {
    id: "manageAddingQuickOrder",
    padding:35, type:"space",
    rows: testContent2  
}