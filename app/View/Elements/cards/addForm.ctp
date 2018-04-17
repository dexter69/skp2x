<div id="kartadd" class="cards form">
    <?php echo $this->Form->create('Card', array('type' => 'file')); ?>
    <fieldset  class="mono">
        <legend><span>NOWA KARTA</span><span>NOWE KARTY</span></legend>
        <?php
        /* */
        echo $this->Form->input('multi', [
            'default' => 1,
            'type' => 'number',
            'min' => 1,
            'max' => 99,
            'div' => ['class' => 'input number mti'],
            'label' => false
        ]);

        echo $this->Form->input('zrobZamo', [
            'default' => 1,
            'type' => 'checkbox',
            'div' => ['class' => 'input checkbox zz'],
            'label' => 'Zamówienie'
        ]);
        
        echo $this->Form->hidden('Card.owner_id', array( 'default' => $ownerid ) );
        echo $this->Form->hidden('Card.customer_id', array('label' => 'Klient', 'type' => 'text', 'default' => 0));

        $markup =
            $this->Form->input('Card.name', $vju['name']) .
            $this->Form->input('klient', array('div' => array('class' => 'input text required'), 'required' => true));
        $this->Ma->responsive_divs( $markup, 'karta_klient');

        echo $this->Ma->viewheader('MATERIAŁ, KOLORYSTYKA', array('class' => 'masymetric')); 
        $this->Ma->responsive_divs( $this->Ma->make_cmyk($vju), 'cmykownia');

        echo $this->Ma->viewheader('OPCJE SITA', array('class' => 'masymetric')); 
        $this->Ma->responsive_divs( $this->Ma->make_sito($vju), 'sitoza');


        echo $this->Ma->viewheader('INNE OPCJE', array('class' => 'masymetric')); 
        $this->Ma->responsive_divs( $this->Ma->make_options($vju), 'moreoptions');

        $this->Ma->responsive_divs( $this->Ma->make_perasoAndFcomment($vju), 'perso_and_comm');

        //do przechowywania personalizacji
        echo $this->Form->hidden('perso_help');

        echo $this->Ma->viewheader('PLIKI');

        echo $this->Ma->wspolne_pliki($wspolne);

        echo $this->Form->input('Upload.files.',$vju['file']);

        echo $this->Html->tag('table', '', array('id' => 'filetable'));

        ?>

    </fieldset>

<?php echo $this->Form->end('Zapisz'); ?>

</div>