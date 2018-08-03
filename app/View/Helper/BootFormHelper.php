<?php
/**
 * CakePHP BootFormHelper
 * Ma to być pomoc przy tworzeniu formularzy zformatowanych pod bootstrap
 */
class BootFormHelper extends AppHelper {

    public $helpers = array('Form', 'Html');    

    /**
     * Funkcja tworząca 'form-group' w formularzach
     */

     public function formGroup( $label = NULL, $divClass = NULL, $input = [] ) {

        
        $divClass = $divClass ? "form-group " . $divClass : "form-group";
        $upperPartOfDiv = "<div class=\"$divClass\">";

        $time = time();
        $inputId = isset($input['id']) ? $input['id'] : "id" . time();
        $inputType = isset($input['type']) ? $input['type'] : "text";
        $inputClass = isset($input['class']) ? $input['class'] . " form-control" : "form-control";
        $inputPlaceHolder = isset($input['placeHolder']) ? $input['placeHolder'] : NULL;
        $poleInput = "<input id=\"$inputId\" type=\"$inputType\" class=\"$inputClass\" placeholder=\"$inputPlaceHolder\">";
        
        $poleLabel = "<label for=\"$inputId\">$label</label>";       
        
        return "$upperPartOfDiv$poleLabel$poleInput</div>";
     }
    
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
