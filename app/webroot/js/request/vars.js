var

tabelaKart = {
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
},

mainKol1 = { template: "Something else 1" },
mainKol2 = { template: "Something else 2" },

naglowek = { type:"header", template:"My App!"},

body = {
  cols: [
    mainKol1,
    mainKol2
  ]
},

appStructure = {
  container:"myApp",
  rows: [
    naglowek,
    body
  ]  
}

;