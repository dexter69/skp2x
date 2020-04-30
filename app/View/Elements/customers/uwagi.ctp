<?php
echo $this->BootForm->input('comment', [
        'label' => 'Uwagi',
        'placeHolder' => 'Uwagi. Tekst, który wpiszesz w nawiasy klamrowe, np. { ważna informacja }, zostanie wyświetlony, jako przypomnienie, przy składaniu zamówienia.',
        'div' => ['class' => 'col-md-12'],
        'rows' => 13
]);
