<div class="multi-wrap">
<?php
    echo $this->Form->input('multi', [
        'default' => 1,
        'type' => 'number',
        'min' => 1,
        'max' => 99,
        'div' => ['class' => 'input number mti'],
        'label' => false
    ]);        

    echo $this->Form->input('Card.price', [
        'default' => 0,
        'type' => 'text',
        'div' => ['class' => 'input text cenka'],
        'label' => false
    ]);

    echo $this->Form->input('zrobZamo', [
        'default' => 1,
        'type' => 'checkbox',
        'div' => ['class' => 'input checkbox zz'],
        'label' => 'Zamówienie'
    ]);
?>
</div>