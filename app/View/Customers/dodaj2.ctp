<?php
$this->set('title_for_layout', 'Nowy Klient');
$this->layout='bootstrap';
?>

<form>
    <div class="row">
        <div class="col-md-9">
            <div class="row"> 
                <?php
                    echo $this->element('customers/nazwa', []);                
                ?>
            </div>
        </div>
        <!-- <div class="col-md-1"></div> -->
        <div class="col-md-3">
            <div class="row">
                <?php echo $this->element('customers/czasWalutaEtykieta', []); ?>
            </div>
            <div class="row">
                <?php //echo $this->element('customers/payments', []); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <?php                
                    echo $this->element('customers/contactNIP', []);
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row">
                <?php echo $this->element('customers/payments', []); ?>
            </div>
        </div>
    </div>
</form>