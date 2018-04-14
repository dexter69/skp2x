var karty = [
    { id:1, lp:1, name:"Zielona", ile: 1000, cena: 0},
    { id:2, lp:2, name:"Żółta", ile: 2000, cena: 0}          
];

var tabelaDlaKart = {
    id: 'gsdgsg',
    view:"datatable",  
    columns:[
  
        { id:"lp", header:"Lp.", fillspace:true },
        { id:"name", header:"Nazwa karty", fillspace:true },
        { id:"ile", header:"Ilość", fillspace:true },
        { id:"cena", header:"Cena", fillspace:true }            
    ],
    //autowidth:true,
    
   data: karty
   //[ { id:1, lp:1, name:"Zielona", ile:1994, cena:678790}, { id:2, lp:2, name:"Żółta", ile:1972, cena:511495}]
  };

var tabelaDlaKart1 = {
    view:"datatable",  
    columns:[
      /*
        { id:"lp", header:"Lp.", fillspace:true },
        { id:"name", header:"Nazwa karty", fillspace:true },
        { id:"ile", header:"Ilość", fillspace:true },
        { id:"cena", header:"Cena", fillspace:true }
  */
        { id:"rank",	editor:"text",		header:"", css:"rank",  		width:50},
                      { id:"title",	editor:"text",		header:"Film title",width:200},
                      { id:"year",	editor:"text",		header:"Released" , width:80},
                      { id:"votes",	editor:"text",		header:"Votes", 	width:100}
    ],
    //,autowidth:true
    /*
    ,data: [
      { id:1, title:"The Shawshank Redemption", year:1994, votes:678790, rating:9.2, rank:1},
      { id:2, title:"The Godfather", year:1972, votes:511495, rating:9.2, rank:2}
    ]
    */
   data: [
    { id:1, title:"The Shawshank Redemption", year:1994, votes:678790, rating:9.2, rank:1},
    { id:2, title:"The Godfather", year:1972, votes:511495, rating:9.2, rank:2}
  ]
  };

