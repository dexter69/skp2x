<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
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
            
            //echo $this->Html->css( array('bootswatch/custom/bootstrap.min', 'boot/core') );
            echo $this->BootHtml->css( array('bootswatch/custom/bootstrap.min', 'boot/core.css?v=201706301029'), false );
            ?>
            <!--
                wersja local 
                <link rel="stylesheet" type="text/css" href="/SKP/2x/css/boot/core.css?v=29042200" />
            -->
            <!--
                 wersja na apacz'a
            
            <link rel="stylesheet" type="text/css" href="/skp/css/boot/core.css?v=29042200" />
            -->
        <?php
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
    </head>
    <body>
        <?php 
        /*
        echo $this->Session->setFlash('Bla, bla - jakiś błąd.'
                        //);
                        , array('element' => '/bootstrap/failure'));
        */            
            echo $this->element('navbar');            
        ?>
        
        <div class="container">
            <?php
            echo $this->Session->flash(
                'flash'
                ,['element' => '/bootstrap/failure']
            ); 
            echo $this->fetch('content'); ?>
        </div>
        
        
        <!-- Bootstrap core JavaScript
        ================================================== 
        Placed at the end of the document so the pages load faster -->        
        <?php
            echo $this->Html->script(array(
                'jquery-1.11.2.min'
                , 'bootstrap.min.js'
                //, 'bootstrap_3.37.min.js'
            ));
            echo $this->fetch('scriptBottom');
        ?>
    </body>
</html>        
 
 