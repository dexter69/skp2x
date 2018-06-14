<?php
define(CSV, ";");
$in = "./2018-06-14/maj.csv";


$arr = []; // tu wrzucimy dane z pliku

$h = fopen($in,"r");
if( $h ) {
  $arr = fillUpArr($h);
  $comp = compactData($arr);
  
  putItOut($comp);
  //print_r($comp);
  fclose($h);
  
} else {
  echo "Can't open the $in file";
}

//wydrukuj tablicę
function putItOut( $tab ) {
 
    foreach( $tab as $row ) {
      echo implode(CSV, $row) . "\n";
    }    
}
// Karty zamieniamy w pojedyncze zlecenie
function compactData( $dane ) {
    // w $dane[0] jest nagłowek tabeli    
    
    $daneWy = [];
    $now = 1;
    $row = formIt($dane[$now]); // zkompaktowany wiersz wyłuskany z dane, w tym momencie to pierwszy wiersz
    $arrlen = count($dane);
    while( $now < $arrlen ) {
      $now++;      
      if( $row['3'] == $dane[$now]['3'] ) { // takie samo id zamowienia
        $row['6'] = (string)((int)$row['6'] + (int)$dane[$now]['6']); // dodajemy karty
      } else { // kolejne zmowienie
        $daneWy[] = $row; // gotowy wiersz do danych wy      
        $row = formIt($dane[$now]);  
      }
    }
    return $daneWy;
}

// zformatuj odpowiednio dane
function formIt( $tab ) {

  $ludziki = [
    '2' => 'Beata',
    '3' => 'Agnieszka',
    '10' => 'Renata',
    '11' => 'Marzena',
    '31' => 'Piotr'
  ];

  $tab['0'] = $ludziki[$tab['0']]; // uzytkownik
  $tab['4'] = (int)substr($tab['4'], -5) . "/" . substr($tab['4'], 0, 2);
  //$tab['8'] = '<a href="http://skp.lan/orders/view/' . $tab['3'] . '">' . $tab['4'] . '</a>';
  
  return $tab;
}

// wrzucamy dane z pliku do tablicy, bo łatwiej operować
function fillUpArr( $inH ) {

  $tmpArr = [];

  while( !feof($inH) )  {
    $l = trim(fgets($inH)); 
    $tmpArr[] = explode(CSV, $l);
  }
  return $tmpArr;
}

