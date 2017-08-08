<div class="col-md-1">
    <p>
    id: 
        <b>
        <?= 
            $piece['Disposal']['id'] 
            
        ?>
        </b>
    </p>
    <p><?= 
        $this->Html->link(
            $this->Boot->bnr2nrh( $piece['Disposal']['nr'] )
            , array(
                'controller' => 'orders',
                'action' => 'view',
                $piece['Disposal']['id']
            )
            , ['target' => '_blank']
        )
    ?></p>
</div>