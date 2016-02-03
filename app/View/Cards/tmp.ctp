<?php
$proof = $answer['dane']['Proof'];
$karta = $answer['dane']['Card'];
$waluta = $answer['dane']['Customer']['waluta'];
$jezyk = $answer['dane']['Customer']['proof-lang'];
$wju = $answer['dane']['vju'];
$answer['dane']['model'] = $this->Proof->skomponujModel($proof, $karta, $waluta, $wju, $jezyk);
$this->Proof->printR($answer);