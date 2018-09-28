//Top toolbar

let userInfo = 
//{ view: "button", type: "icon", value: "Zosia", width: 65, css: "app_button", icon: "user-o",  badge:"Darek"};
{ view:"button", type:"icon", icon:"user", label: "Gibon"//globalAppData.loggedInUser.name
, width:95, id:'xyz', css:'kwa-mia-hau'
};

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



