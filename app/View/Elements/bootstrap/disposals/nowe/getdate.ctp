<?php
// potrzebne pliki js i css
echo $this->element('bootstrap/datepickers/subels/head'); ?>

<input id="mhi">
<div id="datoza" data-date-language="pl" data-date-today-highlight="true"></div>

<?php echo $this->Boot->bottomScript($this->element('bootstrap/disposals/nowe/js')); ?>