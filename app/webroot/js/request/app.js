/*
* Starting point of webix addedit request app
*/

webix.ready(function(){
    
    console.log("App - I'm here");

    webix.ui({
        container:"myApp",
          rows:[
            { type:"header", template:"My App!"},
            { cols:[
                 {},
                 {},
                 {}
            ]}      
          ]   
      });
    
});