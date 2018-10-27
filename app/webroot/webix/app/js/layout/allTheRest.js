let allTheRest = {
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
};