//Top toolbar

let userInfo = { 
    view:"button", type:"icon", icon:"user",
    label: globalAppData.loggedInUser.name, // Tu leci Imię zalogowanego użytkownika
    width: 110, id:'userInfoToolbar',
    css:'kwa-mia-hau',    // w celach testowych
    //click: logoutHandler  <= w taki sposób, jeżeli chcemy użyć osobnej funkcji
    click: function (){ window.open(globalAppData.config.logoutUrl, "_self"); }
}
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
        { view: "label", label: " ", width: 68},
        toolbarMenu,        
        
        //toggleSwitch,
        {},
        userInfo
        //,{ view: "button", type: "icon", width: 45, css: "app_button", icon: "envelope-o",  badge:4},
        //{ view: "button", type: "icon", width: 45, css: "app_button", icon: "bell-o",  badge:10}
    ]
};





