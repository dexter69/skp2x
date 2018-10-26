let theOrderDetail = {
    id: "theOrderDetail",
    view: "template",
    // Zaczynamy bez zdefiniowanej template, bedzie uaktualniona, po kliknieciu w rekord
    //template: "<label>id:</label><p>#idx#</p><label>klient:</label><p>#klient#</p>",    
    gravity: 1
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