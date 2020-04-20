
<div class='col-md-4'>
    <h1 class="text-primary"><?php echo $naglowek ?></h1>
</div>

<?php

echo $this->BootForm->input('name', [
        'label' => 'Nazwa skrócona',
        'placeHolder' => 'krótka nazwa klienta',
        'div' => ['class' => 'col-md-4']
]);

echo $this->BootForm->input('vatno_txt', [
    'label' => 'NIP',
    'placeHolder' => 'nip',
    'div' => ['class' => 'col-md-4'],
    // Bootstrap tooltip
    'data-toggle' => 'tooltip',    
    'data-placement' => 'left',
    'title' =>  'NIP opcjonalnie może zaczynać się od DUŻYCH liter (max 3), następnie cyfry,
                które (dla dodania czytelności) możesz porozdzielać spacjami lub myślnikami.'
]);