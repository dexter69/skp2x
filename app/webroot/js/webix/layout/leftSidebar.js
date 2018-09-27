let menu_data = [
    {id: "side-klienci", icon: "address-book-o", value: "Klienci",  data:[
        { id: "side-klienci-list", value: '<i class="fa fa-list" aria-hidden="true"></i> Lista'},
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
    collapsed: true
};