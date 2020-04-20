<?php

echo $this->BootForm->input('comment',
    [
        'label' => 'Uwagi',
        'placeHolder' => 'uwagi',
        'div' => ['class' => 'col-md-7']
    ]
);

echo $this->BootForm->input('important',
    [
        'label' => 'Ważne!',
        'placeHolder' => "Informacje o których trzeba pamiętać przy zamówieniu - to co tutaj wpiszesz, będzie się pojawiać jako „przypominajka” przy składniu/edycji zamówienia dla tego klienta.",
        'div' => ['class' => 'col-md-5']
    ]
);