<?php $this->set('title_for_layout', 'Handlowy'); ?>
<script type="text/javascript" charset="utf-8">

/*
Globalny obiekt, przechowywyjący różne użyteczne dane */
var globalAppData = {
    loggedInUser: <?php echo json_encode($loggedInUser); ?>, // Info o zalogowanym użytkowniku
    config: { // różnorakie przydatne dane
        logoutUrl: "/users/logout"
    }   
};


webix.ready(function(){ //to ensure that your code is executed after the page is fully loaded
  
    webix.ui({
        //container: "myApp",   
        rows:[
            mainToolbar,
            { 
                cols:[
                    leftSidebar,
                    allTheRest // zawartość
                ]
            }             
        ]   
    });

});

</script>
