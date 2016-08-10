<?php
// coby zasysał odpowiedni css, w zależności gdzie działa (na starym czy nowym)
$fields = get_class_vars('DATABASE_CONFIG');
if( $fields['default']['ver'] == 'new' ) { // czy jesteśmy na nowym serwerze?
    // TAK - inny css
    echo $this->Html->css(array('job/job-pdf'), array('inline' => false));
} else { // w przeciwnym wypadku standard
    echo $this->Html->css(array('job-pdf'), array('inline' => false));
}
// po staremu //echo $this->Html->css(array('job-pdf'), array('inline' => false/*, 'fullBase' => true*/));

$index = 0;
$i = 0; // ile elementów drukniętych
//$tablica = array_merge( $job['Card'], $job['Card'], $job['Card'], $job['Card'], $job['Card']  );
//$tablica = array_merge( $job['Card'], $job['Card'] );
$tablica = $job['Card'];
foreach( $tablica as $karta ) {
   if( $i == 7 ) { //już 7 rzeczy drukniętych, więc następna strona
       $i = 0;
   }
   if( $i == 0 ) { //pierwszy na stronie jest naglowek
       echo $this->Pdf->job_PrintNaglowek($job);
       $i++;
   }   
   $karta['klient'] = $ordery[$karta['id']]['Customer']['name'];
   $karta['nr_zamowienia'] = $ordery[$karta['id']]['Order']['nr'];
   $karta['inic'] = $ordery[$karta['id']]['User']['inic'];
   $karta['termin'] = $ordery[$karta['id']]['Order']['stop_day'];
   echo $this->Pdf->job_PrintKarte( $karta/*, $coptions*/ ); 
   $i++;
}


?>


<?php
//echo '<pre>';	print_r($ordery); echo  '</pre>';
//echo '<pre>';	print_r($job); echo  '</pre>';
//echo '<pre>';	print_r($tablica); echo  '</pre>';

