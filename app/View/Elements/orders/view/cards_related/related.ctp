<div class="related">
<?php
    $related = $this->Order->cardsRelated( $order, $evcontrol );
    echo $related['viewHeader'];

    if (!empty($order['Card'])) {                                               

        echo $this->element('orders/view/cards_related/karty', [
                'extraTh' => $related['extraTh'],
                'ta_klasa' => $related['ta_klasa'],
                'tbody'	=> $related['tbody']
        ]);

    }
?>
</div>