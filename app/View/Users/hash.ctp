<?php 
//echo '<pre>';	print_r($wynik); echo  '</pre>'; 

$i = 0;
echo 'czas = ' . $czas . '<br>';
echo 'mzi = ' . $mzi . '<br>';
echo 'jest = ' . $jest . '<br>' . 'ilość = ' . count($wynik) . '<br><br>';
echo '<pre>';
foreach($wynik as $row)   {
    echo $row . '</br>';
}
echo '</pre>';