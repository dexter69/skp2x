let orderDetails_listOfCards = {

    id: "orderDetails_listOfCards",
    view: "datatable",    
    gravity: 0.6,
    //hidden:true,
    columns: [
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"id", header:"id", adjust:true },
        { id:"name", header:"Karta", fillspace:true },
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    }
};