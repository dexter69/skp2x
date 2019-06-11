// Menu w głównym pasku narzedziowym
let toolbarMenu = {
    id: "toolbarMenu",
    view:"menu",    
    data: [ // elementy menu
        // whereToGo posiada informację, gdzie ten item przełącza
        {   id: "klienci", value:"Klienci", icon: "address-book-o",
            whereToGo: manageCustomers.id },/**/
        {   id: "prywatne", value:"Prywatne", icon: "handshake-o",
            whereToGo: "managePrivateOrders" }
            
    ],
    css: "toolbar-menu",
    ready: function(){ // Zakoloruj odpowiedni element menu    
        $$(toolbarMenu.id).disableItem("klienci");
    },
    on:{
        /* Po kliknięciu w elem. menu aktywujemy go (używając webix'owego disablowania)
        i ładujemy odpowiedni komponent "podpięty" do tego menu */
        onMenuItemClick:function(id){            
            // ... whereToGo zawiera informację gdzie trzeba przełączyć
            $$(this.getMenuItem(id).whereToGo).show();
            $$(toolbarMenu.id).config.data.forEach(function(menuItem){
                // "Zinabluj" kazdy element menu
                $$(toolbarMenu.id).enableItem(menuItem.id); 
            });
            $$(toolbarMenu.id).disableItem(id);
        }
    }
}