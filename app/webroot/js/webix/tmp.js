webix.ready(function(){
    webix.ui({
        rows: [
            { view: "toolbar", padding:3, elements: [
                { view: "button", type: "icon", icon: "bars",
                    width: 37, align: "left", css: "app_button", click: function(){
                        $$("$sidebar1").toggle();
                    }
                },
                { view: "label", label: "My App"},
                {},
                { view: "button", type: "icon", width: 45, css: "app_button", icon: "envelope-o",  badge:4},
                { view: "button", type: "icon", width: 45, css: "app_button", icon: "bell-o",  badge:10}
            ]
            },
            { cols:[
                {
                    view: "sidebar",
                    data: menu_data,
                    on:{
                        onAfterSelect: function(id){
                            webix.message("Selected: "+this.getItem(id).value)
                        }
                    }
                },
                { template: ""}
            ]}
        ]
    });
});