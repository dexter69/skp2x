let sample_cards = [
    { id:1, lp:1, name:"Zielona", ile: 1000, cena: 0},
    { id:2, lp:2, name:"Żółta", ile: 2000, cena: 0},
    { id:3, lp:3, name:"Czerwona", ile: 3000, cena: 0}        
];

let kolumny = [
    /*  id property mówi, co będzie wyświetlane w tej kolumnie.
        Czyli, jeżeli mamy "lp", to odpowiada to property lp
        w wierszu danych -> patrz sample cards*/
    { id:"lp", header:"Lp.", fillspace:true },
    { id:"name", header:"Nazwa karty", fillspace:true },
    { id:"ile", header:"Ilość", fillspace:true },
    { id:"cena", header:"Cena", fillspace:true }            
];

let tabelaKart = {
    id: "tkart",
    view:"datatable",  
    autowidth: true,

    /*  Wersja 1 */
    // columns:kolumny, data: sample_cards,     
    
    /* Wersja 2 */    
    autoConfig: true, data: sample_cards
   
  };



