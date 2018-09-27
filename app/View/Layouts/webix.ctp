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
        /* echo $this->Html->css(['/webix/v5.4.0/codebase/webix', '/webix/core.css?v=' . time()]);
            Dajemy swoją skórkę */
        echo $this->Html->css([
            //'/webix/v5.4.0/codebase/webix', <-- Oryginalny
            '/webix/v5.4.0/skin/504a75b5/webix', // skórka
            '/webix/core.css?v=' . time()
        ]);
        echo $this->Html->script([
            '/webix/v5.4.0/codebase/webix_debug',
            '/webix/v5.4.0/skin/504a75b5/skin', // potrzebne do skórki -> patrz readme.txt

            'webix/layout/toolbar.js?v=' . time(),
            'webix/layout/sidebar.js?v=' . time(),
            'webix/content/allTheRest.js?v=' . time()
        ]);
        
        ?>
    </head>
    <body>
        <!--<div id="myApp"></div>  kontener dla naszej aplikacji -->
        <?php echo $this->fetch('content'); ?>
    </body>
</html>