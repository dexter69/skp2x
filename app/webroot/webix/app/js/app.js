//@prepros-prepend ./content/customers/listOfCustomers.js
//@prepros-prepend ./content/orders/addNewQuickOrder.js
//@prepros-prepend ./content/customers/customerDetail.js
//@prepros-prepend ./content/customers/customerPanel.js
//@prepros-prepend ./content/orders/privateOrders/conf.js
//@prepros-prepend ./content/orders/privateOrders/eventsHandlers.js
//@prepros-prepend ./content/orders/theOrderDetail/listOfCards.js
//@prepros-prepend ./content/orders/theOrderDetail/theOrderDetail.js
//@prepros-prepend ./content/orders/privateOrders/listOfPrivateOrders.js
//@prepros-prepend ./content/orders/managePrivateOrders.js                  
//@prepros-prepend ./content/customers/manageCustomers.js 
//@prepros-prepend ./layout/toolbarMenu.js
//@prepros-prepend ./layout/mainToolbar.js
//@prepros-prepend ./layout/leftSidebar.js                
//@prepros-prepend ./layout/content.js

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