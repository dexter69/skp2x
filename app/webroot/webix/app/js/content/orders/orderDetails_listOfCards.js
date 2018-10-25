let orderDetails_listOfCards = {

    id: "orderDetails_listOfCards",
    view: "datatable",
    orderId: 0,
    columns: [
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"id", header:"id", adjust:true },
        { id:"name", header:"Karta", fillspace:true },
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    },
    dane: [] // tu będą dane o kartach po kliknięciu w listę zamówień
};