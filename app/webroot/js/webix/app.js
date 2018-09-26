/*
* Starting point of webix addedit request app
  allData - globalna zmienna ze wszystkimi danymi
  Poniżej wykorzystujemy różne obiekty, które są zdefiniowane w vars.js
  Ten plik jest załączany w layoucie webix.ctp powyżej app.js
*/

webix.ready(function(){
    
  // Szerzej mówiąc cały komponent ze wszystkimi rzeczami do kart
  let theCardManager =  tabelaKart;

  let theApp = {
    container:"myApp",
    rows: [
      { view:"template", // nie musi być (tutaj, tzn działa bez, dałem w celach edukacyjnych)
        type:"header", template:"Test App!"},
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