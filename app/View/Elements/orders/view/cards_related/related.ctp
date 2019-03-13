<div class="related">
<?php
    echo $related['viewHeader'];

    if ( $weHaveCards ) {                                               

        echo $this->element('orders/view/cards_related/karty', [
                'extraTh' => $related['extraTh'],
                'ta_klasa' => $related['ta_klasa'],
                'isleft' => $related['isleft'],
                'tbody'	=> [
                    'html' => $related['html'],
                    'sigma' => $related['sigma']                   
                ]
        ]);

    }
?>
</div>