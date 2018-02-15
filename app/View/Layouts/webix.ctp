<?php
/**
* Layout for webix: https://webix.com/
 */
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <title><?php echo $title_for_layout; ?></title>
        <meta charset="utf-8">
        <?php        
        echo $this->Html->meta('icon');

        // Webix CSS & JavaScript =====================
        echo $this->Html->css(['/webix/v5.1.1/codebase/webix']);
        echo $this->Html->script(['/webix/v5.1.1/codebase/webix']);
        
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <script type="text/javascript" charset="utf-8">
        webix.ui({
            rows:[
                { view:"template", 
                    type:"header", template:"My App!" },
                { view:"datatable", 
                    autoConfig:true, 
                    data:{
                    title:"My Fair Lady", year:1964, votes:533848, rating:8.9, rank:5
                    }
                }
            ]
        });
        </script>

        
        <?php            
        echo $this->fetch('scriptBottom');
        ?>
    </body>
</html>