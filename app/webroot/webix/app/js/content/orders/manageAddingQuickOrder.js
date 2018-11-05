
let manageAddingQuickOrder = {
    id: "manageAddingQuickOrder",
    padding: globalAppData.config.wyglad.mainPad, //35,
    type:"space",
    //rows: testContent2  
    cols: [
        addNewQuickOrder,
        { gravity: 0.005 }, //Taki spacer
        listOfCustomers
    ]
}