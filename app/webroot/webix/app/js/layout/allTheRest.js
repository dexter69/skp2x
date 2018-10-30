let allThePrivateOrdersFullV1 = {
    padding:50,
    type:"space",
    rows: [ 
        {type: 'header', template: 'Tu będzie sterujący toolbar probably ...'},
        //addNewQuickOrder
        {
            cols: [
                privateOrders,
                {gravity: 0.02},// taki spacer              
                 
                {
                    rows: [
                        theOrderDetail,
                        theOrderDetail_listOfCards
                    ]                    
                }     
                          
            ]
        }
        
    ]
}

let allThePrivateOrdersFullV2 = { // Bez Header'a
    padding:35,
    type:"space",    
    cols: [
        privateOrders,
        {gravity: 0.02},// taki spacer            
        {
            rows: [
                theOrderDetail,
                theOrderDetail_listOfCards
            ]                    
        }     
                    
    ]        
}

let addingNewOrderWidget = {
    padding:35,
    type:"space",
    cols: [
        addNewQuickOrder,
        { gravity: 0.005 }, //Taki spacer
        listOfCustomers
    ]
}

let allTheRest = 

addingNewOrderWidget;

//allThePrivateOrdersFullV2;