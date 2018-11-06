#!/bin/bash
# 2018-11-05 Lepsza wersja
# Skrypt generujacy losowe ciągi znaków o wybranej długości na bazie openssl

ILE=70000 #ile generujemy stringów
DL=25	  # długość większa

#tr usuwa wszystkie niealfanumeryczne znaki,
#a head obcina do długości 20 znaków

COUNTER=0
while [ $COUNTER -lt $ILE ]; do
	#echo Licznik wynosi $COUNTER
	openssl rand -base64 $DL | tr -cd '[:alnum:]' | head -c${1:-20}; echo;
	let COUNTER=COUNTER+1
done
echo $COUNTER
echo
