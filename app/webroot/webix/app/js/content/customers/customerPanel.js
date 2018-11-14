/**
 * Component zawierający szczegóły o wybranym kliencie + możliwość dodania do niego zamówienia */

 let customerPanel = {
     id: "customerPanel",
     animate: {subtype:"in"},
     gravity: 0.8,
     hidden: true,
     cells: [
        //{template: "Dummy", width: 100},
        customerDetail,
        addNewQuickOrder
     ]
 }