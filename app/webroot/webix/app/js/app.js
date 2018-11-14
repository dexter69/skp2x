/**
 * Główny plik js */
webix.ready(function(){ //to ensure that your code is executed after the page is fully loaded
  
    let layout = {
        id: "theLayout", 
        css: 'app-main',
        rows:[
            mainToolbar,
            { 
                cols:[
                    leftSidebar,
                    content// zawartość
                ]
            }             
        ]   
    }    

    webix.ui(
        layout 
    );

});