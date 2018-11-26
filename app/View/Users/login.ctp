<?php 	$this->layout = 'login';?>
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