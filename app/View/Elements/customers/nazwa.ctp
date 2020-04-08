<?php

echo $this->BootForm->input('name',
    [
        'label' => 'Nazwa skrócona',
        'placeHolder' => 'krótka nazwa klienta',
        'div' => ['class' => 'col-md-9']
    ]
);

$vju['pozyskany']['div'] = ['class' => 'col-md-3']; // wolimy w widoku formatować podział na kolumny
echo $this->BootForm->input('pozyskany', $vju['pozyskany']);

echo $this->BootForm->input('AdresSiedziby.name',
    [
        'label' => 'Pełna nazwa',
        'placeHolder' => 'pełna nazwa klienta',
        'div' => ['class' => 'col-md-12']
    ]
);

echo $this->BootForm->input('AdresSiedziby.ulica',
    [
        'label' => 'Ulica',
        'placeHolder' => 'ulica',
        'div' => ['class' => 'col-md-9']
    ]
);

echo $this->BootForm->input('AdresSiedziby.nr_budynku',
    [
        'label' => 'Numer',
        'placeHolder' => 'numer',
        'div' => ['class' => 'col-md-3']
    ]
);

echo $this->BootForm->input('AdresSiedziby.kod',
    [
        'label' => 'Kod',
        'placeHolder' => 'kod pocztowy',
        'div' => ['class' => 'col-md-3']
    ]
);

echo $this->BootForm->input('AdresSiedziby.miasto',
    [
        'label' => 'Miasto',
        'placeHolder' => 'miasto',
        'div' => ['class' => 'col-md-5']
    ]
);

echo $this->BootForm->input('AdresSiedziby.kraj',
    [
        'label' => 'Kraj',
        'placeHolder' => 'kraj',
        'div' => ['class' => 'col-md-4']
    ]
);
