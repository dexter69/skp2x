<script type="text/javascript" charset="utf-8">

/*
Globalny obiekt, przechowywyjący różne użyteczne dane */
var globalAppData = {
    loggedInUser: <?php echo json_encode($loggedInUser); ?> // Info o zalogowanym użytkowniku
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
