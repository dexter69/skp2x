let theOrderDetail = {
    id: "theOrderDetail",
    gravity: 0.5
}

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
                //orderDetails_listOfCards
                /**/ 
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