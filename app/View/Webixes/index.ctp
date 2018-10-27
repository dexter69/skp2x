<?php
    $this->set('title_for_layout', 'Handlowy');    
    $theOrderDetail  = $this->App->trimAll($this->element('webixes/theOrderDetail'));
?>

<script type="text/javascript" charset="utf-8">

/*
Globalny obiekt, przechowywyjący różne użyteczne dane */
var globalAppData = {
    loggedInUser: <?php echo json_encode($loggedInUser); ?>, // Info o zalogowanym użytkowniku
    config: { // różnorakie przydatne dane
        logoutUrl: "/users/logout"
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