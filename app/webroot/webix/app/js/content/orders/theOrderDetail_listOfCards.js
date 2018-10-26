let theOrderDetail_listOfCards = {

    id: "theOrderDetail_listOfCards",
    view: "datatable",    
    //gravity: 0.5,    
    columns: [
        { id:"index", header:"", sort:"int", width:35 },
        { id:"id", header:"id", width:60 },
        { id:"name", header:"Nazwa karty", fillspace:true },
    ],
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    }
};