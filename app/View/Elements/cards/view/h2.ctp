<?php 
//echo '<pre>';	print_r($card); echo  '</pre>'; 
//echo $this->Ma->cechyKarty( $card );
//echo '<pre>';	print_r($this->Ma->tablica_cech); echo  '</pre>'; 
//if( $this->Ma->tablica_cech['isperso'] ) echo 'Gibon';



if( $card['pvis'] ) {
    $klasa = array(	
        'dtpcheck'=>null, 'persocheck'=>null, 'all-but-priv'=>null,
        'my'=>null, 'active'=>null, 'closed'=>null, 'ponly'=>null,
        'pover'=>null, 'ptodo'=>null, 'hot'=>null
    );
    echo '<h2 class="hfiltry">' . $this->Ma->indexFiltry('cards', $klasa) . '</h2>';
}
?>

<h2 class="karta-header">
    <i class="fa fa-cubes" aria-hidden="true"></i>
    <span><?php echo $card['name']; ?></span>
    <a href="/cards/edit/<?php echo $card['id']; ?>" title="Edycja karty">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
    </a>
    <?php echo $this->Ma->cechyKarty( $card, 'wju' ); ?>
</h2>
<?php $this->Ma->nawiguj( $links, $card['id'] ); //nawigacyjne do dodaj, usuń, edycja itp.