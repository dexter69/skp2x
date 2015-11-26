<div id="cmykwrap">
    <?php echo $this->Ma->viewheader('MATERIAŁ, KOLORYSTYKA'); ?>
    <table id="cardcmyk" class="cardviewtable">
    <?php
    $cells[] = array('materiał', $vju['x_material']['options'][$card['a_material']], $vju['x_material']['options'][$card['r_material']]);
    $cells[] = array('laminat', $vju['x_lam']['options'][$card['a_lam']], $vju['x_lam']['options'][$card['r_lam']]);
    $cells[] = array('cmyk',
            $vju['x_c']['options'][$card['a_c']].
            $vju['x_m']['options'][$card['a_m']].
            $vju['x_y']['options'][$card['a_y']].
            $vju['x_k']['options'][$card['a_k']],
            $vju['x_c']['options'][$card['r_c']].
            $vju['x_m']['options'][$card['r_m']].
            $vju['x_y']['options'][$card['r_y']].
            $vju['x_k']['options'][$card['r_k']]
     );
    if( $card['a_pant'] || $card['r_pant'] ) {
        $cells[] = array('pantony', $card['a_pant'],  $card['r_pant']);
    }
    echo $this->Html->tableHeaders(array('', 'awers', 'rewers'));
    echo $this->Html->tableCells($cells);
    ?>
    </table>
    <?php 
        if( $card['cmyk_comment'] )
            { echo '<div class="smallcomment"><p>uwagi (materiał, kolorystyka):</p>'.nl2br($card['cmyk_comment']).'</div>'; }
    ?>
</div>		