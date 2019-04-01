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

$cakeDescription = __d('cake_dev', 'SKP');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
            <?php //echo $cakeDescription ?>
            <?php echo $title_for_layout; ?>
    </title>
    <?php
            echo $this->Html->meta('icon');            
            		
			echo $this->Html->css($this->App->makeCssJsTable(["cake.generic", "global", "font-awesome-4.6.1/css/font-awesome.min"], "css"));
					
			echo $this->Html->script($this->App->makeCssJsTable(["lib/jquery-2.1.4.min", "funkcje"], 'js'));

			echo $this->Html->script($this->App->makeCssJsTable(["common"], 'js'), ['block' => 'scriptBottom']);
			
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');

    ?>
</head>
<?php // dodatkowa klasa do wyświetlania tła w innym kolorze dla zakkończonych zamówień
	if( isset($konec) && $konec ) {
		$bstr = " class='archived'";
	} else {
		$bstr = "";
	}	
?>
<body <?php echo $bstr;?>>        
	<div id="container">
		<div id="header">			
			<?=	$this->element('forLayouts/leftIcons', ['departament' => $departament] ); ?>
			<div id="szukanie" class="hid">
				<?php echo $this->Ma->formularzSzukajKarty(); ?>
			</div>
			<?=	$this->element('forLayouts/rightIcons', ['juzer' => $juzer]/*['departament' => $departament]*/ ); ?>
			<div class="stopfloat"></div>			
		</div>
		<div id="content" class="dexmodif">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<!--<hr style="color: orange; width: 1000px">-->
			<?php 
				/*
				echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);*/
			?>
		</div>
	</div>
	<?php //echo $this->element('sql_dump');
		echo $this->fetch('scriptBottom');
		//echo $this->Js->writeBuffer(); // Write cached scripts 
	?>
</body>
</html>
