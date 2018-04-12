<?php
/*  $id, przypisywane do js var idh, id zamówienia, które ma być edytowane.
    Jeżeli jest to nowe zamówienie, to $id = 0; */

echo $this->Html->scriptBlock("var idh = $id;", array('inline' => true));

//echo $this->Html->script('./request/addedit', ['charset' => 'utf-8']);