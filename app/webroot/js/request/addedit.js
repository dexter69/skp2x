/*
* Starting point of webix addedit request app
*/
var tekst = "";

if( edycja ) {
    tekst = " - edycja";
    console.log(edycja);
} else {
    tekst = " - nowe";
    console.log("NOWE");
}

//var gornyNaglowek = { view:"toolbar", /*type:"header",*/ template:"My App!" + tekst};
var gornyNaglowek = {
    view:"toolbar", elements: [
        {template: "My App!" + tekst},
        {}]
};

webix.ready(function(){
    webix.ui({
        //container:"app_here",
        //view:"layout", // optional
        rows:[
            gornyNaglowek,
            { cols:[
                {},
                {},
                {}
            ]}      
          ]   
      });
});

