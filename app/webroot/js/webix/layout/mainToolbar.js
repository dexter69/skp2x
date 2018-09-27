//Top toolbar
let mainToolbar = {
    responsive: true,
    view: "toolbar", padding:3,
    elements: [
    { view: "button", type: "icon", icon: "bars",
        width: 37, align: "left", css: "app_button", click: function(){
            $$("lewy-sidebar").toggle();
        }
    },
    { view: "label", label: "Handlowe !"},
    {},
    { view: "button", type: "icon", width: 45, css: "app_button", icon: "envelope-o",  badge:4},
    { view: "button", type: "icon", width: 45, css: "app_button", icon: "bell-o",  badge:10}
    ]
};

