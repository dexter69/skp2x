<?php
    $this->set('title_for_layout', 'Handlowy');    
    $theOrderDetail  = $this->App->trimAll($this->element('webixes/theOrderDetail'));
?>

<script type="text/javascript" charset="utf-8">

/*
Globalny obiekt, przechowywyjący różne użyteczne dane */
var globalAppData = {
    loggedInUser: <?php echo json_encode($loggedInUser); ?>, // Info o zalogowanym użytkowniku
    customerOwners: [
        {id: 0, value: "Wszyscy"},    
        {id: 3, value: "Agnieszka"},
        {id: 17, value: "Ania"},
        {id: 2, value: "Beata"},
        //{id: 1, value: "Darek"},
        {id: 4, value: "Jola"},
        {id: 11, value: "Marzena"},
        {id: 31, value: "Piotr"},
        {id: 10, value: "Renata"}            
    ],    
    config: { // różnorakie przydatne dane
        logoutUrl: "/users/logout",

        // url do zasysania klientów lda celów dodania nowego zamówienia
        customersAddOrder: "/webixCustomers/getForAddingAnOrder.json"
    },
    template: { // tu bardziej złożone tamplates        
        theOrderDetail: "<?php echo $theOrderDetail; ?>"      
    } 
};

webix.ready(function(){ //to ensure that your code is executed after the page is fully loaded
  
    let layout1 = {
        id: "theLayout", 
        rows:[
            mainToolbar,
            { 
                cols:[
                    leftSidebar,
                    allTheRest // zawartość
                ]
            }             
        ]   
    }    

    webix.ui(
        layout1 // 1 - pierwsza wersja, 2 - druga wersja
    );

});

</script>