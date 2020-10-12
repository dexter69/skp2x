<?php
/** Layout: Bootstrap + pdfmake 
 */
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <title><?php echo $title_for_layout; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php
            echo $this->Html->meta('icon');            
            
            echo $this->BootHtml->css( array('bootswatch/custom/bootstrap.min', 'boot/core'), true );
            
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
    </head>
    <body>
        <?php 
            //echo $this->Session->flash(); 
            echo $this->element('navbar');
        ?>
        
        <div class="container">
            <?php echo $this->fetch('content'); ?>
        </div>
        
        
        <!-- Bootstrap core JavaScript
        ================================================== 
        Placed at the end of the document so the pages load faster -->        
        <?php
            echo $this->Html->script(array('jquery-1.11.2.min', 'bootstrap/bootstrap.min'));
            //oraz pdf make
            echo $this->Html->script(array('lib/pdfmake.min', 'lib/vfs_fonts')); 
            echo $this->fetch('scriptBottom');
        ?>
    </body>
</html>        
 
 