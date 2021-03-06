<?php
echo $this->Html->css(array(
        'etykiety/label.css?v=201804051418' //. time()
        //,'font-awesome-4.6.1/css/font-awesome.min'
    ),
    array('inline' => false));
echo $this->Html->script(array(
    'etykiety/label-funkcje.js?v=201804051418', //. time(),
    'etykiety/label2.js?v=201804051418'//. time()
    ),
    array('block' => 'scriptBottom')
); 
$this->set('title_for_layout', 'Etykiety');
//$this->layout='bootstrap';
$this->layout='bootstrap-pdfmake';

// formularz do znajdowania
echo $this->element('tasks/label/getTaskForm', array(
    'msg' => $result['msg'],
    'nr' => $result['data']['Task']['nr']
));

if( $result != null ) { // znaczy było POST
    if( !empty($result['data']) ) { // mamy coś ?>
        <div class="row">            
            <?php $i=0;
            $produkcyjne = $this->Ma->bnr2nrj($result['data']['Task']['nr'], null, false);
            foreach( $result['data']['Ticket'] as $karta ) { 
                    $karta = $this->Task->countDataForEtykFromCardData($karta);
                    echo $this->element('tasks/label/kodKarty', array(
                        'karta' => $karta,
                        'divclass' => 'col-sm-6 label-summary ' . $karta['klasa'],
                        'lp' => ++$i,
                        'box' => $box,
                        'parcel' => $parcel,
                        'produkcyjne' => $produkcyjne,
                        // info, czy osoba jest z odpowiedniego działu, tylko perso i ew. inni, którzy potrzebują, beda mieli wyświetlany zakres
                        'properDzial' => $result['properDzial']
                    ));
                    //$this->App->print_r2($karta); 
                //}                
            } ?>
        </div>        
        <?php
        // umieszczamy "szkielet" skryptu pod pdfmake w elemencie, bo tak nam wygodnie
        echo $this->element('tasks/label/pdfSkeleton');        
    } 
}

//echo $this->App->print_r2($jnr);
