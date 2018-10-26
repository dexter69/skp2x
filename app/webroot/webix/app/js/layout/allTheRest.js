let theOrderDetail = {
    id: "theOrderDetail",
    view: "template",
    css: "theOrderDetail", // na razie nie używam - tak testowo
    // Zaczynamy bez zdefiniowanej template, bedzie uaktualniona, po kliknieciu w rekord        
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