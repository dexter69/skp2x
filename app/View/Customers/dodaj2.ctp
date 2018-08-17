<?php
$this->set('title_for_layout', 'Nowy Klient');
$this->layout='bootstrap';
?>

<form>
    <div class="row">
        <div class="col-md-8">
            <div class="row"> 
                <?php
                    echo $this->element('customers/nazwa', []);                    
                ?>
            </div>
        </div>        
        <div class="col-md-4">
            <div class="row">
                <?php echo $this->element('customers/contactAndNip', []); ?>
            </div>           
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php echo $this->element('customers/prepaid', []); ?>
        </div>
        <div class="col-md-4">
            <?php echo $this->element('customers/afterpay', []); ?>
        </div>
        <div class="col-md-4">
            <?php echo $this->element('customers/czasWalutaEtykieta', []); ?>
        </div>        
    </div>
    
</form>