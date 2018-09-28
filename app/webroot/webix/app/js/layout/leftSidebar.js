let menu_data = [
    {id: "side-klienci", icon: "address-book-o", value: "Klienci",  data:[
        { id: "side-klienci-list", value: '<i class="fa fa-list" aria-hidden="true"></i> Lista' },
        { id: "side-klienci-add", value: '<i class="fa fa-plus" aria-hidden="true"></i> Dodaj'}
    ]},
    {id: "side-karty", icon: "credit-card", value:"Karty", data:[
        { id: "side-karty-list", value: '<i class="fa fa-list" aria-hidden="true"></i> Lista'},
        { id: "side-karty-add", value: '<i class="fa fa-plus" aria-hidden="true"></i> Dodaj'}
    ]},
    {id: "side-handlowe", icon: "handshake-o", value:"Handlowe", data:[
        { id: "side-handlowe-list", value: '<i class="fa fa-list" aria-hidden="true"></i> Lista'},
        { id: "side-handlowe-add", value: '<i class="fa fa-plus" aria-hidden="true"></i> Dodaj'}
    ]},
    {id: "side-produkcyjne", icon: "industry", value:"Produkcyjne", data:[
        { id: "side-produkcyjne-list", value: '<i class="fa fa-list" aria-hidden="true"></i> Lista'},
        { id: "side-produkcyjne-add", value: '<i class="fa fa-plus" aria-hidden="true"></i> Dodaj'}
    ]}    
];

let leftSidebar = {
    view: "sidebar",
    id: "lewy-sidebar",
    data: menu_data,
    collapsed: true,
    on: {
            onAfterSelect: function(id){
                
                let where, act=true;
                switch(id) {
                    case "side-klienci-list":
                        where = "customers";
                        break;
                    case "side-klienci-add":
                        where = "customers/add";
                        break;
                    case "side-karty-list":
                        where = "cards";
                        break;
                    case "side-karty-add":
                        where = "cards/add";
                        break;
                    case "side-handlowe-list":
                        where = "orders";
                        break;
                    case "side-handlowe-add":
                        where = "orders/add";
                        break;
                    case "side-produkcyjne-list":
                        where = "jobs";
                        break;
                    case "side-produkcyjne-add":
                        where = "jobs/add";
                        break;
                    default:
                        act = false;
                }
                if( act ) {
                    window.open(where, "_self");
                }                
            }
    }
};
/*
click:function(){
    window.open("<a target='_blank' href='http://docs.webix.com'>Webix Docs</a>");
}
*/

/* Ikony zagnieżdżone też działają, ale jak sidebar nie jest collapsed

https://snippet.webix.com/z60bmqjk

var menu_data_multi  = [
    { id: "structure", icon: "columns", value:"Structuring", data:[
      { id: "layouts", icon:"circle", value:"Layouts", data:[
        { id: "layout", icon:"circle-o", value: "Layout"},
        { id: "flexlayout", icon:"circle-o", value: "Flex Layout"},
        { id:"strict", icon:"circle-o", value:"Precise Positioning", data:[
          { id: "gridlayout", icon:"circle-o", value: "Grid Layoot"},
          { id: "dashboard",  icon:"circle-o", value: "Dashboard"},
          { id: "abslayout", icon:"circle-o", value: "Abs Layout"}
        ]},
        { id: "datalayouts", icon:"circle-o", value:"Data Layouts",  data:[
          { id: "datalayout", icon:"circle-o", value: "Data Layout"},
          { id: "flexdatalayout",  icon:"circle-o", value: "Flex Data Layout"},
        ]}
      ]},
      {id: "multiviews", icon:"circle", value:"Multiviews", data:[
        { id: "multiview", icon:"circle-o", value: "MultiView"},
        { id: "tabview",  icon:"circle-o", value: "TabView"},
        { id: "accordion",  icon:"circle-o", value: "Accordion"},
        { id: "carousel", icon:"circle-o", value: "Casousel"}
      ]}
    ]},
    {id: "tools", icon: "calendar-o", value:"Tools", data:[
      { id: "kanban", icon:"circle", value: "Kanban Board"},
      { id: "pivot", icon:"circle", value: "Pivot Chart"},
      { id: "scheduler", icon:"circle", value: "Calendar"}
    ]},
    {id: "forms", icon: "pencil-square-o", value:"Forms",  data:[
      {id: "buttons", icon:"circle", value: "Buttons", data:[
        {id: "button", icon:"circle-o", value: "Buttons"},
        {id: "segmented", icon:"circle-o", value: "Segmented"},
        {id: "toggle", icon:"circle-o", value: "Toggle"},
      ]},
      { id:"texts", icon:"circle", value:"Text Fields", data:[
        { id: "text", icon:"circle-o", value: "Text"},
        { id: "textarea", icon:"circle-o", value: "Textarea"},
        { id: "richtext", icon:"circle-o", value: "RichText"}
      ]},
      { id:"selects", icon:"circle", value:"Selectors", data:[
        { id:"single", icon:"circle-o", value:"Single value", data:[
          { id: "combo", icon:"circle-o", value: "Combo"},
          { id: "richselect", icon:"circle-o", value: "RichSelect"},
          { id: "select", icon:"circle-o", value: "Select"}
        ]},
        { id:"multi", icon:"circle-o", value:"Multiple values", data:[
          { id: "multicombo", icon:"circle-o", value: "MultiCombo"},
          { id: "multiselect", icon:"circle-o", value: "MultiSelect"}
        ]}
      ]}
    ]},
    {id: "demo", icon: "book", value:"Documentation"}
  ];
*/