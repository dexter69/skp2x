<?php
if( $edycja ) {
    $tytul = 'Edycja Klienta';
    $hidden = $this->Form->hidden('AdresSiedziby.id');    
} else {
    $tytul = 'Nowy Klient';
    $hidden = null;
}
?>

<style>
.form-group.required > label:after { 
   content:" *";
   color:red;
}
</style>

<h1 class="text-primary"><?php echo strtoupper($tytul)?></h1>

<?php
$this->set('title_for_layout', $tytul);
$this->layout='bootstrap';

// We want it at the bootom of the page
echo $this->Html->script('customer/klient.js?v=' . time(), array('block' => 'scriptBottom'));
echo $this->Html->scriptBlock( $code, array('block' => 'scriptBottom') );

echo $this->Form->create();
echo $hidden;
?>

    <div class="row">
        <div class="col-md-8">
            <div class="row"> 
                <?php
                    echo $this->element('customers/nazwa', []); 
                    echo $this->element('customers/pay', []); ?>
            </div>
        </div>        
        <div class="col-md-4">
            <div class="row">
                <?php
                    echo $this->element('customers/contactAndNip', []);
                    echo $this->element('customers/czasWalutaEtykieta', []); ?>
            </div>           
        </div>
    </div>
    <div class="row">
        <?php echo $this->element('customers/uwagi', []); ?>
    </div>

<?php echo $this->BootForm->end(['label' => 'Zapisz', 'class' => 'btn btn-primary']);

//$this->App->print_r2($this->request->data);