<!--
    Chcemy dostarczy ładnego elementu "select" na bazie button dropdawn.
    Wybranie elementu z listy bedzie powodowało zapis w predefiniowanej js zmiennej.
-->
<?php
    // Podstawowe sprawdzenie parametrów
    
    $result = $this->element('bootstrap/selects/subels/check', array(        
        'options' => $opcje
    ));
    //echo $result;
    /* */
    //echo '<pre>'; print_r($options); echo '</pre>';
    if( $result != 'ok' ) {
        $options = [
          'els' => ['err', 'err1'],
          'default' => 0
        ];
    } else {
        $options = $opcje;
    }    
?>
<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php echo $options['els'][$options['default']];?> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <?php
        foreach( $options['els'] as $li) {
            echo '<li><a href="#">' . "$li</a></li>";
        }
    ?>    
  </ul>
</div>
