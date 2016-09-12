<?php
/**
 * CakePHP BootFormHelper
 * Ma to być pomoc przy tworzeniu formularzy zformatowanych pod bootstrap
 */
class BootFormHelper extends AppHelper {

    public $helpers = array('Form');    
    
    //
    public function input( $tekst, $opcje= array() ) {
        
        $options= array(
            'class' => 'form-control',
            'div' => array(
                'class' => 'form-group col-xs-3'
            ),
            'pattern' => "[0-9]{1,4}",
            'title' => "tylko cyfry, wartość z zakresu 1 - 9999",
            'placeholder' => "tylko cyfry, wartość z zakresu 1 - 9999",
            'maxlength' => "4"
        );
        if( isset($opcje['label']) ) {
            $options['label'] = $opcje['label'];
        }
        return $this->Form->input($tekst, $options);
    }
    
    // zakończ formularz
    public function end( $opcje = array() ) {
        
        $label = isset($opcje['label']) ? $opcje['label'] : null;
        $div = isset($opcje['div']) ? $opcje['div'] : false;
        $options = array(
            'label' => $label,
            'div' => $div,
            'class' => 'btn btn-default'
        );
        return $this->Form->end($options);
    }

}
