<?php 
//echo '<pre>';	print_r($card); echo  '</pre>'; 
//echo $this->Ma->cechyKarty( $card );
//echo '<pre>';	print_r($this->Ma->tablica_cech); echo  '</pre>'; 
//if( $this->Ma->tablica_cech['isperso'] ) echo 'Gibon';



if( $card['pvis'] ) {
    $klasa = array(	
        'dtpcheck'=>null, 'persocheck'=>null, 'all-but-priv'=>null,
        'my'=>null, 'active'=>null, 'closed'=>null, 'ponly'=>null,
        'pover'=>null, 'ptodo'=>null
    );
    echo '<h2 class="hfiltry">' . $this->Ma->indexFiltry('cards', $klasa) . '</h2>';
}
?>
<h2><?php 	
    echo '<span>'.$card['name'].'</span>' . 
    $this->Ma->editlink('card', $card['id']); 
    echo $this->Ma->cechyKarty( $card, 'wju' );
?>
</h2>
<?php $this->Ma->nawiguj( $links, $card['id'] ); //nawigacyjne do dodaj, usuń, edycja itp.