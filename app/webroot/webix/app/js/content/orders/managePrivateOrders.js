
let managePrivateOrders = {
    id: "managePrivateOrders",
    padding: globalAppData.config.wyglad.mainPad, //35,
    type:"space",
    //rows: testContent1    
    css: "moj-naglowek",
    cols: [
        listOfPrivateOrders,
        {gravity: 0.01},// taki spacer  
        {
            rows: [                
                theOrderDetail,
                listOfCards
            ]                    
        }
    ]
}