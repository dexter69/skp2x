<div id="proof-form" class="proofs form"><?php
    echo $this->Form->create('Proof', array( 'action' => 'update' )); ?>
        <fieldset><?php
            echo $this->Form->input('id');
            echo $this->Form->input('card_id', array('type' => 'text'));
            echo $this->Form->input('waluta');
            echo $this->Form->input('a_kolor');
            echo $this->Form->input('r_kolor');
            echo $this->Form->input('size');
            echo $this->Form->input('uwagi');?>
        </fieldset><?php
    echo $this->Form->end(); ?>
</div>