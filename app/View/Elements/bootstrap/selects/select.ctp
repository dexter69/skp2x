<!--
    Chcemy dostarczy ładnego elementu "select" na bazie button dropdawn.
    Wybranie elementu z listy bedzie powodowało zapis w predefiniowanej js zmiennej.
-->
<?php
    // Podstawowe sprawdzenie parametrów    
    $options = $this->Boot->selectCtpCheck( $config );
    $title = "Some tooltip text3!";
    if( array_key_exists('opcje', $config) ) {
        $title = $config['opcje'][$config['opcje']['default']]['title'];
    }
?>
<div id="<?php echo $config['id']; ?>" class="btn-group" title="<?php echo $title; ?>">
  <button        
    type="button" class="btn btn-default dropdown-toggle"
    data-toggle="dropdown"
    aria-haspopup="true"
    aria-expanded="false"            
    data-value="<?php echo $options['default'];?>">
    <?php echo $options['els'][$options['default']];?> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <?php
        if( array_key_exists('opcje', $config) ) {
            foreach( $config['opcje'] as $key => $arr) {
                if( $key != 'default' ) {
                    echo '<li value="' . $arr['value'] . '" title="' . $arr['title'] . '"><a href="#">' . $arr['display'] . "</a></li>";
                }
            }
        } else {            
            foreach( $options['els'] as $key => $tekst) {
                echo '<li value="' . $key . '" data-toggle="tooltip" title="Li tooltip"><a href="#">' . "$tekst</a></li>";
            }
        }                
    ?>    
  </ul>
</div>
<?php
$code = $this->App->stripScript(
    $this->element(
        'bootstrap/selects/subels/js', array(
            'id' => $config['id'],
            'acc' => $config['acc'] // gdzie wpisać wartosc wybraną
        )
    )
);
echo $this->Html->scriptBlock($code, array('block' => 'scriptBottom'));
