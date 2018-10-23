let allTheRest = {
    padding:50,
    type:"space",
    rows: [ 
        {type: 'header', template: 'Tu będzie sterujący toolbar probably ...'},
        //addNewQuickOrder
        {
            cols: [
                privateOrders,
                orderDetail
            ]
        }
        
    ]
};

/*  Some toolbar
        { view:"toolbar", id:"mybar", elements:[
            //{}, {}
            
            { view:"button", value:"Add", width: 70},
            { view:"button", value:"Delete", width: 70 },
            { view:"button", value:"Update", width: 70 },
            { view:"button", value:"Clear Form", width: 85 }
            
            ]
        },
    
    Some other elements

    //type:"space",
    //padding:50,
    //margin:60,maxWidth: 1100,  
*/