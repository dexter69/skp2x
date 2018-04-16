let karty = [
    { id:1, lp:1, name:"Zielona", ile: 1000, cena: 0},
    { id:2, lp:2, name:"Żółta", ile: 2000, cena: 0},
    { id:3, lp:3, name:"Czerwona", ile: 3000, cena: 0}          
];

let tabelaDlaKart = {
    id: 'tdk',
    view:"datatable",  
    columns:[
  
        { id:"lp", header:"Lp.", fillspace:true },
        { id:"name", header:"Nazwa karty", fillspace:true },
        { id:"ile", header:"Ilość", fillspace:true },
        { id:"cena", header:"Cena", fillspace:true }            
    ],
    //autowidth:true,
    
   data: karty
   
  };



