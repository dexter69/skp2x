<div class="col-md-2">  
    <p>
    <?= 
        $this->Html->link(
            $this->Boot->bnr2nrh( $piece['Disposal']['nr'], $piece['User']['inic'] )
            , array(
                'controller' => 'orders',
                'action' => 'view',
                $piece['Disposal']['id']
            )
            , ['target' => '_blank', 'escape' => false]
        )
    ?>
    </p>
</div>