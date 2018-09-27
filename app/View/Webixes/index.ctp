<script type="text/javascript" charset="uyf-8">

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
