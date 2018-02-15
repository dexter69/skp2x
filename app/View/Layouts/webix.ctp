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
        
        ?>
    </head>
    <body>       
        <?php echo $this->fetch('content'); ?>        
    </body>
</html>