/*
    Nie wiem czym są id w wierszach danych - 
    Czy to ma coś wspólnego z id komponentów? Chyba nie - po prostu property - można chyba
    odpowiadać id, jakie wiersz ma w bazie.
    Jak widać, gdy ominiemy, wszystko nadal działa. */
    
let sample_cards = [
    {   
        id: 2847,
        lp:1, name:"Zielona", ile: 1000, cena: 0},
    { 
        id: 3456,
        lp:2, name:"Żółta", ile: 2000, cena: 0},
    { 
        id: 1234,
        lp:3, name:"Czerwona", ile: 3000, cena: 0}        
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

    /*  Wersja 1 - z definicją kolumn */
    // columns:kolumny, data: sample_cards,     
    
    /* Wersja 2 - bez definicji kolumn */    
    autoConfig: true, data: sample_cards
   
  };



