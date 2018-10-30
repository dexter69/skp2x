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
            '/webix/app/css/core.css?v=' . time()
        ]);
        echo $this->Html->script([
            '/webix/v5.4.0/codebase/webix_debug',
            '/webix/v5.4.0/skin/504a75b5/skin', // potrzebne do skórki -> patrz readme.txt            
        ]);
        
        ?>
    </head>
    <body>        
        <?php
            echo $this->fetch('content'); 
        
            echo $this->Html->script([
                //Rzeczy potrzebne aplikacji
                '/webix/app/js/content/orders/privateOrders.js?v=' . time(),
                '/webix/app/js/content/orders/theOrderDetail_listOfCards.js?v=' . time(),
                '/webix/app/js/content/orders/theOrderDetail.js?v=' . time(),
                '/webix/app/js/content/orders/addNewQuickOrder.js?v=' . time(),
                '/webix/app/js/content/customers/listOfCustomers.js?v=' . time(),
                
                '/webix/app/js/layout/mainToolbar.js?v=' . time(),
                '/webix/app/js/layout/leftSidebar.js?v=' . time(),                
                '/webix/app/js/layout/allTheRest.js?v=' . time()
            ]);
        ?>
    </body>
</html>