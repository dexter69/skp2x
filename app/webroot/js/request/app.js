/*
* Starting point of webix addedit request app
  allData - globalna zmienna ze wszystkimi danymi
*/

webix.ready(function(){
    
   console.log(allData);

   //webix.ui(appStructure);         

   //webix.ui(tabelaKart);

   

  webix.ui({
    container:"myApp",
    rows: [
      { type:"header", template:"My App!"},
      {
        cols: [
          tabelaDlaKart,
          //{ template: "Something else 1" },
          { template: "Something else 2" }
        ]
      }
    ]
  });
   
   //webix.ui(    tabelaDlaKart  );

});