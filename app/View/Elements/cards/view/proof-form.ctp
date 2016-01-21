<div id="proof-form" class="proofs form"><?php
    echo $this->Form->create('Proof', array( 'action' => 'update' )); ?>
        <fieldset><?php
            echo $this->Form->input('a_kolor');
            echo $this->Form->input('r_kolor'); ?>
        </fieldset><?php
    echo $this->Form->end(); ?>
</div>