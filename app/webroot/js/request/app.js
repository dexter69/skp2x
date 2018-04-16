/*
* Starting point of webix addedit request app
  allData - globalna zmienna ze wszystkimi danymi
*/

webix.ready(function(){
    
   console.log(allData);

  // Szerzej mówiąc cały komponent ze wszystkimi rzeczami do kart
  let theCardManager =  tabelaDlaKart;

  let theApp = {
    container:"myApp",
    rows: [
      { type:"header", template:"My App!"},
      {
        cols: [
          theCardManager,          
          { template: "Something else 2" }
        ]
      }
    ]
  };

  webix.ui( theApp );

});