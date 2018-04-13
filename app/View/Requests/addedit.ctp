<?php
/*  $id, przypisywane do js var idh, id zamówienia, które ma być edytowane.
    Jeżeli jest to nowe zamówienie, to $id = 0; */

$dataForApp = [
    'id' => $id,
    'cos' => 'ktos'
];

echo $this->Html->scriptBlock(    
    "\nvar allData =  "  .  json_encode($dataForApp),
    ['inline' => true]
);
