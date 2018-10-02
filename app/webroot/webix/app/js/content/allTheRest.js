let quickHandlowe = {
    template:"Quick Handlowe"
};
let test = {
    type:"space",
    padding:50,
    //margin:60,
    //padding:50,
    //maxWidth: 1100,    
    rows: [
        {type: 'header', template: 'Co tu będzie nie wiemy...'},
        { cols: [
            quickHandlowe,
            { template:"Col 2", gravity: 0.8 }
          ]
        }
        /*
        { view:"toolbar", id:"mybar", elements:[
            //{}, {}
            
            { view:"button", value:"Add", width: 70},
            { view:"button", value:"Delete", width: 70 },
            { view:"button", value:"Update", width: 70 },
            { view:"button", value:"Clear Form", width: 85 }
            
            ]
        },
        */
        
    ]
};

let allTheRest = {
    
    
    rows: [ test ]
};