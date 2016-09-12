<?php
/**
 * CakePHP BootFormHelper
 * Ma to być pomoc przy tworzeniu formularzy zformatowanych pod bootstrap
 */
class BootFormHelper extends AppHelper {

    public $helpers = array('Form');    
    
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

}
