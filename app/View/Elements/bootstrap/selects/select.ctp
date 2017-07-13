<!--
    Chcemy dostarczy ładnego elementu "select" na bazie button dropdawn.
    Wybranie elementu z listy bedzie powodowało zapis w predefiniowanej js zmiennej.
-->
<?php
    // Podstawowe sprawdzenie parametrów    
    $options = $this->Boot->selectCtpCheck( $config );
?>
<div id="<?php echo $config['id']; ?>" class="btn-group">
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
        foreach( $options['els'] as $key => $tekst) {
            echo '<li value="' . $key . '"><a href="#">' . "$tekst</a></li>";
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
