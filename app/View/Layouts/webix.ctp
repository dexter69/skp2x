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
        echo $this->Webix->css([
            "/webix/v5.4.0/skin/504a75b5/webix", // skórka 
            "/webix/app/css/core"
        ]);

        echo $this->Webix->script(
            [ // wersja DEV
            "/webix/v5.4.0/codebase/webix_debug",
            "/webix/v5.4.0/skin/504a75b5/skin", // potrzebne do skórki -> patrz readme.txt            
            ],
            [ // versja PROD
                "/webix/v5.4.0/codebase/webix",
                "/webix/v5.4.0/skin/504a75b5/skin", // potrzebne do skórki -> patrz readme.txt            
            ]
        );
        ?>
    </head>
    <body>        
        <?php
            echo $this->fetch('content'); 
        
            echo $this->Webix->script(
                $webixJsFiles, // Zdefiniowane w WebixesController. Wersja dev
                ["/webix/app/js/app.min"] // wersja prod
            );
        ?>
    </body>
</html>