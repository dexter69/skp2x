//Top toolbar
function logoutHandler(){
    window.open(globalAppData.config.logoutUrl, "_self");
}

let userInfo = { 
    view:"button", type:"icon", icon:"user",
    label: globalAppData.loggedInUser.name, // Tu leci Imię zalogowanego użytkownika
    width: 110, id:'userInfoToolbar',
    css:'kwa-mia-hau',    // w celach testowych
    click: logoutHandler   
};
// takie testowe było { view: "button", type: "icon", value: "Zosia", width: 65, css: "app_button", icon: "user-o",  badge:"Darek"};

let mainToolbar = {
    responsive: true,
    view: "toolbar", padding:3,
    elements: [
        /*
        { view: "button", type: "icon", icon: "bars",
            width: 37, align: "left", css: "app_button", click: function(){
                $$("lewy-sidebar").toggle();
            }
        },
        */
        { view: "label", label: "Handlowe !"},
        {},
        userInfo
        //,{ view: "button", type: "icon", width: 45, css: "app_button", icon: "envelope-o",  badge:4},
        //{ view: "button", type: "icon", width: 45, css: "app_button", icon: "bell-o",  badge:10}
    ]
};





