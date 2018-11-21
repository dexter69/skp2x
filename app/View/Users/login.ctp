<?php 	$this->layout = 'login';
	if( isset($ajax) ) {
		//$stri = ``;
		$stri = '$ajax is set, = ' . $ajax;
		/*
		if( $ajax === NULL ) {
			$stri .= 'NULL, ';
		}
		if( $ajax == NULL ) {
			$stri .= 'null, ';
		}
		if( $ajax === false ) {
			$stri .= 'false';
		}
		*/		 
	} else {
		//$stri = "NIE ajax";
		$stri = '$ajax is NOT set!';
	}
	
	echo "<p style='background-color: lightpink;'>$stri</p>";
?>
<div class="users form">
<?php //echo $this->Session->flash('auth'); 
	$this->layout = 'login';
?>
<?php echo $this->Form->create('User'); ?>
    <fieldset><!--
        <legend>
        	<?php echo 'Logowanie'; ?>
		</legend>-->
        <?php 
        	echo $this->Form->input('username', array('label' => 'Login', 'class' => 'logoza' ));
        	echo $this->Form->input('password', array('label' => 'Hasło', 'class' => 'logoza' ));
    	?>
    </fieldset>
<?php echo $this->Form->end(__('Zaloguj')); ?>
</div>