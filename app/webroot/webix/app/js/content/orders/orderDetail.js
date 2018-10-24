let sample = [
 
    { 'id': 12792, name: "Karta1", order_id:6829 }, 
    { 'id': 12801, name: "Karta2", order_id:6829 }
];
let orderDetail = {
    id: "orderDetailListOfCards",
    view: "datatable",
    orderId: 0,
    columns: [
        { id:"index", header:"", sort:"int", adjust:true },
        { id:"id", header:"id", adjust:true },
        { id:"name", header:"Karta", fillspace:true },
    ],
    /*
    data: [
        { 'id': 12792, name: "Karta1", order_id:6829 }, 
        { 'id': 12801, name: "Karta2", order_id:6829 }
    ],
     */
    //url: "webixOrders/getOneOrderLight/6829.json",
    //data: sample,
    url: function(){
        let url = "webixOrders/getOneOrderLight.json";
        console.log(orderDetail.orderId);
        return webix.ajax(url).then(function(data){
            let dane = data.json();              
            return dane;                           
        })        
    },
    scheme:{
        $init:function(obj){ obj.index = this.count(); }
    },
    
    //dataFeed: "costam.php"
};



/*
webix.ready(function(){    
   $$("orderDetailListOfCards").bind( $$("privo")
   , function(slave, master){ return slave.order_id == master.WebixPrivateOrder_id;  }
    );
});
*/



