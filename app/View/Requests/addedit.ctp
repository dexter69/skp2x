<?php
/*  $id ma wartość id zamówienia, które ma być edytowane.
    Jeżeli jest to nowe zamówienie, to $id = 0; */

$dataForApp = json_encode([
    'id' => $id,
    'cos' => 'ktos'
]);

echo $this->Html->scriptBlock(        
    "var allData =  $dataForApp;",
    ['inline' => true]
);
