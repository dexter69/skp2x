<?php
$proof = $answer['dane']['Proof'];
$karta = $answer['dane']['Card'];
$waluta = $answer['dane']['Customer']['waluta'];
$jezyk = $answer['dane']['Customer']['proof-lang'];
$wju = $answer['dane']['vju'];
echo json_encode($answer);