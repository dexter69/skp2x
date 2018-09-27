/*
* Poniżej wykorzystujemy różne obiekty, które są zdefiniowane w components.js
  Ten plik jest załączany w layoucie webix.ctp powyżej app.js
*/

webix.ready(function(){ //to ensure that your code is executed after the page is fully loaded
  
  webix.ui({
    container: "myApp",   
      rows:[
        mainToolbar,
        { 
          cols:[
            leftSidebar,
            allTheRest // zawartość
          ]
        } 
             
      ]   
  });

});