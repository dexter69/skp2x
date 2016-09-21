<?php
echo $this->Html->css(array(
        'etykiety/label.css?v=' . time()
        //,'font-awesome-4.6.1/css/font-awesome.min'
    ),
    array('inline' => false));
echo $this->Html->script(array('etykiety/label'), array('block' => 'scriptBottom')); 
$this->set('title_for_layout', 'Etykiety');
//$this->layout='bootstrap';
$this->layout='bootstrap-pdfmake';

// formularz do znajdowania
echo $this->element('tasks/label/getTaskForm', array('msg' => $result['msg']));

if( $result != null ) { // znaczy było POST
    if( !empty($result['data']) ) { // mamy coś ?>
        <div class="row">
        <?php $i=0;
        foreach( $result['data']['Ticket'] as $karta ) {            
            echo $this->element('tasks/label/kodKarty', array(
                'karta' => $karta,
                'divclass' => 'col-sm-6 label-summary',
                'lp' => ++$i,
                'box' => $box
            ));
        } ?>
        </div>        
        <?php
        // umieszczamy "szkielet" skryptu pod pdfmake w elemencie, bo tak nam wygodnie
        echo $this->element('tasks/label/pdfSkeleton');
        //echo "<br>";
        //$this->App->print_r2($result['data']/*['Ticket']*/); // prezentuj
    } 
}
