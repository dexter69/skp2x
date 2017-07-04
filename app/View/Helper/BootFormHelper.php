<?php
/**
 * CakePHP BootFormHelper
 * Ma to być pomoc przy tworzeniu formularzy zformatowanych pod bootstrap
 */
class BootFormHelper extends AppHelper {

    public $helpers = array('Form', 'Html');    
    
    //
    public function input( $tekst, $opcje = array() ) {
        
        $opcje['class'] = isset($opcje['class']) ? $opcje['class'] . " form-control" : "form-control";
        $opcje['div']['class'] = isset($opcje['div']['class']) ? $opcje['div']['class'] . " form-group" : "form-group";
        
        return $this->Form->input($tekst, $opcje);
    }
    
    // zakończ formularz
    public function end( $opcje = null ) {
        
        if(is_string($opcje) ) {
            $label = $opcje;
            $div = false;
        } else {
            $label = isset($opcje['label']) ? $opcje['label'] : null;
            $div = isset($opcje['div']) ? $opcje['div'] : false;
        }
        $options = array(
            'label' => $label,
            //'div' => $div,
            'class' => 'btn btn-default'
        );
        if( $div ) {
            $options['div'] = $div;
        }
        return $this->Form->end($options);
    }

    /* ########################  Datepicker
    
        USES bootstrap datepicker
        https://bootstrap-datepicker.readthedocs.io
    */
    public function placeDatePicker($config = array()) {

        $this->pickerHeaders();
        
    }

    private function pickerHeaders() {

        echo $this->Html->css(
            '../my-bootstrap-date-picker/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker3.min'
        );

        echo $this->Html->script(
            array(
                '../my-bootstrap-date-picker/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.min',
                '../my-bootstrap-date-picker/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker_pl.min',            
                '../my-bootstrap-date-picker/picker.js?v=' . time()
            ),
            array('block' => 'scriptBottom')
        );

    }

}
