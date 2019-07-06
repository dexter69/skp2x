/**
 * Component zawierający szczegóły o wybranym kliencie
 * + możliwość dodania do niego zamówienia */

 let buttDl = 90;
 let customerDetailToolbar = {
     id: "customerDetailToolbar",
     view: "toolbar",
     gravity: 0.19,
     css: "customer-detail-toolbar",     
     elements: [
        //{ id:"btest5", view:"button", value:"Add", click: "sTCB"},        
        {   id: "more", view:"button", type:"icon", icon:"info-circle",
            css: "cd-button", click: "sTCB", width:buttDl},
        {},                      
        { id:"cd_delete", view:"button", css: "cd-kosz cd-button",
            type:"icon", icon:"trash-o", badge:0, click: "sTCB", width:buttDl },
        {},
        { id:"closeIt", view:"button",  css: "cd-button",
            type:"icon", icon:"times", click: "sTCB", width:buttDl}
     ],
     obsluzKlikniecieBatona: function(idBatona) {
         
        // ID klienta
        let theId = $$(listOfCustomers.id).getSelectedItem().WebixCustomer_id;
        switch(idBatona) {
            case "closeIt":                
                // To samo jest w listOfCustomer.onAfterFilter => trzeba to jakoś w jeden kod zamienić
                if( $$(customerPanel.id).isVisible() ) {                    
                    $$(customerPanel.id).hide(); // Schowaj szczegóły klienta                    
                    $$(listOfCustomers.id).config.showTheColumns(); // Pokaż z powrotem schowane kolumny
                    $$(listOfCustomers.id).clearSelection();                 
                }
                break;   
            case "more":                                                
                window.open(globalAppData.config.customerUrl + theId, "_blank");
                break;  
            case "cd_delete": // usuwanie klienta
                webix.confirm({
                    title: "POTWIERDŹ USUNIĘCIE",// the text of the box header
                    text: "Klient oraz powiązane z nim dane - zamówienia, karty zostaną USUNIĘTE! Kontynuowć?",
                    ok: "Tak",
                    cancel: "NIE",
                    callback: function(okUsuwamy) { // true - kliknął YES
                        
                        if ( okUsuwamy ) { 
                            // użytkownik potwierdził usunięcie => więc usuwamy!
                            let delUrl = globalAppData.config.delCustomerUrl + theId + ".json";
                            webix.ajax(delUrl, function(text, data) {  // usuwamy klienta                  
                                $dl = text.search("err");
                                if( $dl >= 0 ) { // prawidłowa odpowiedź (w sensie jonson)
                                    console.log(data.json());
                                    if( !data.json().err ) { // skutecznie usunięty
                                        // Filtrujemy ponownie, by nam zniknął usunięty element                            
                                        $$(listOfCustomers.id).filterByAll();
                                        //let xyz = $$(listOfCustomers.id).getSelectedId(); webix.message("we ARE HERE! + " + xyz);                           
                                    }
                                } else {                        
                                    // zakładamay, że to oznacza brak zalogowoania
                                    window.open("/pulpit", "_self");
                                }
                            });
                        }                    
                    }
                });                
                break;
            default:
                webix.message(idBatona); 
        }     
     }
 }

 // Wrap do customerDetailToolbar.obsluzKlikniecieBatona dla krótkości
 // czyli serveTheClickedButton
 function sTCB(buttonId) {    
    $$(customerDetailToolbar.id).config.obsluzKlikniecieBatona(buttonId);
 }

 let customerPanel = {
     id: "customerPanel",
     animate: {subtype:"in"},
     gravity: 0.8,
     hidden: true,
     css: "customer-panel",
     cells: [
        //{template: "Dummy", width: 100},
        {rows:[customerDetailToolbar, customerDetail]},
        addNewQuickOrder
     ]
 }