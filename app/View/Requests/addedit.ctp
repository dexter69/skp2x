<?php
/*  $id ma wartość id zamówienia, które ma być edytowane.
    Jeżeli jest to nowe zamówienie, to $id = 0; */

$dataForApp = json_encode([
    'id' => $id,
    //'cos' => 'ĘÓĄŚŁŻŹĆŃęóąśłżźćń'
    'cos' => 'Ala ma kota'
]);

echo $this->Html->scriptBlock(        
    "var allData =  $dataForApp;", [
        'inline' => true,
        'charset' => 'utf-8',
        'safe' => false,    /*  Nie chcemy <![CDATA[ ]]>, bo nie oczekujemy,
                                że ktoś z 15-letnią przeglądarką,
                                będzie używał tej aplikacji  */    
        'type' => false     // jest i tak defaultowy
    ] 
);
