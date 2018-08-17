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

        
        if( !isset($input['id'])  ) { $input['id'] = "id" . time(); }
        $inputId = $input['id'];

        if( !isset($input['class'])  ) {
            $input['class'] = "form-control";
        } else { 
            $input['class'] .= " form-control";
        }        
        
        if( !isset($input['type'])  ) { $input['type'] = "text"; }

        switch( $this->inputType($input) ) {
            case "select":
                $poleInput = $this->makeSelectMarkup( $input );
                break;
            case "textarea":                
                unset($input['type']);
                $poleInput = "<textarea ";
                foreach( $input as $key => $value ) {
                    $poleInput .= "$key=\"$value\" ";
                }                        
                $poleInput .= "></textarea>";
                break;
            default:
                $poleInput = "<input ";
                foreach( $input as $key => $value ) {
                    $poleInput .= "$key=\"$value\" ";
                }                        
                $poleInput .= ">";
        }
        
        $poleLabel = "<label for=\"$inputId\">$label</label>";       
        
        if( $divClass ) {
            $divClass .= " form-group";
        } else {
            $divClass = "form-group";
        }        
       
        return "<div class=\"$divClass\">$poleLabel$poleInput</div>";
     }

     private function isItSelect( $input = [] ) {

        if( isset($input['type']) && $input['type'] == "select" ) { return true; }
        return false;
     }     

     /*
     zwraca rodzaj inputa: "select", "textarea", "text" */
     private function inputType( $input = [] ) {

        if( isset($input['type']) ) {

            switch( $input['type'] ) {
                case "select":
                case "textarea":
                case "text":
                    return $input['type'];
                default:
                    return "text";
            }
        }
        return "text";
     }

     private function makeSelectMarkup( $input = [] ) {

        $theId = $input['id']; $theClass = $input['class'];
        /* $input['default'] powinno zawierać nr kolejnej (nic wspólnego z kluczem -> wartością) opcji,
          licząc 0, 1, 2 ... */
        $def = isset($input['default']) ? $input['default'] : NULL; 
        if( $this->isItSelect($input) && isset($input['selectOptions']) ) {            
            $markup = "<select id=\"$theId\" class=\"$theClass\">";
            $i=0;
            foreach( $input['selectOptions'] as $print => $value ) {
                $defMarkup = ( $def === $i++) ? ' selected' : NULL;
                $markup .= "<option value=\"$value\"$defMarkup>$print</option>";
            }
            $markup .= "</select>";
            return $markup;
        } else {
            return $this->errSelectMarkup( $theId ); // zwróć markup pokazujący, ze jest jakiś błąd
        }
     }

     private function errSelectMarkup( $inputId ) {

        return "<select id=\"$inputId\" class=\"form-control\"><option value=\"err1\">Err1</option><option value=\"err2\">Err2</option></select>";
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
