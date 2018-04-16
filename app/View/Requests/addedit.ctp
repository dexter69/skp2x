<?php
/*  $id ma wartość id zamówienia, które ma być edytowane.
    Jeżeli jest to nowe zamówienie, to $id = 0; */

$dataForApp = [
    'id' => $id,
    'cos' => 'ktos'
];

echo $this->Html->scriptBlock(    
    "\n" . "var allData =  "  .  json_encode($dataForApp),
    ['inline' => true]
);
