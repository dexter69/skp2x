// Menu w głównym pasku narzedziowym
let toolbarMenu = {
    id: "toolbarMenu",
    view:"menu",
    aaa: "gibon",
    data: globalAppData.config.dataForManuInToolbar.items,
    css: "toolbar-menu",
    on:{
        onMenuItemClick:function(id){
            webix.message("Click: "+this.getMenuItem(id).value);
            console.log(this.getMenuItem(id));
        }
    },
    // Używamy webixowego disablowania menu itemka, by wyróżnić aktywny no i nie potrzebujemy klikać w niego
    activateMenuItem: function(viewId){ // viewId => id view, które żądało aktywacji
        globalAppData.config.dataForManuInToolbar.items.forEach(function(menuItem){
            $$(toolbarMenu.id).enableItem(menuItem.id); // "Z inabluj" kazdy element menu
        });
        // Zasysamy faktyczne Id itemka
        let itemId=globalAppData.config.dataForManuInToolbar.associations[viewId];        
        $$(toolbarMenu.id).disableItem(itemId); // zaktywuj konkretny
    }
}