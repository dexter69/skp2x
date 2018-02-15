/*
* Starting poin of webix addedit request app
*/

webix.ready(function(){
    webix.ui({
        container:"app_here",
        view:"layout", // optional
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

if( edycja ) {
    console.log(edycja);
} else {
    console.log("NOWE");
}