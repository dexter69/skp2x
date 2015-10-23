<?php
echo "Wszyscy klienci w bazie = " . count($klienci['tablica']) . '<br>';
//echo "W tym ci, co zamówili coś w 2015 = " . $klienci['aktywni'];
echo "W tym ci Zagraniczni = " . $klienci['aktywni'];
echo '<pre>'; print_r($klienci); echo '</pre>';