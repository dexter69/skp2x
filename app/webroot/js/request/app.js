/*
* Starting point of webix addedit request app
*/

webix.ready(function(){
    
    console.log("App - I'm here");

    webix.ui({
        container:"myApp",
          rows:[
            { view:"template", type:"header", template:"My App!"},
              { cols:[
                 {},
                 {},
                 {}
              ]}      
          ]   
      });
    
});