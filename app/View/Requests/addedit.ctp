<?php
// $edycja przechowuje informację czy mamy do czynienia z edycją czy z nowym zamówieniem
// Jeżeli jest to edycja, to $edycja ma wartość id zamówienia, w przeciwnym wypadku 0

echo $this->Html->scriptBlock("var edycja = $edycja;", array('inline' => true));

echo $this->Html->script('./request/addedit', ['charset' => 'utf-8']);