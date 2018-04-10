<?php

echo $this->Html->css(array('order', 'sunny/jquery-ui-1.10.4.custom.min'), array('inline' => false));
echo $this->Html->script(array('jquery', 'jquery-ui', 'jquery.ui.datepicker-pl'), array('inline' => false));
$code = "var platnosci = " . json_encode($pays) . ";\n" .
		"var pay = " . json_encode( array( PRZE, CASH ) ) . ";\n" .
		"var defproc = " . json_encode(DEF_ZAL_PROC) . ";\n" .
		
		"var adresy = " . $this->Ma->mjson($adresy) . ";\n" .
		"var czas_realiz = " . ORD_TIME . ";";
		
echo $this->Html->scriptBlock($code, array('block' => 'scriptBottom'));
echo $this->Html->script( 'order-add', array('block' => 'scriptBottom'));