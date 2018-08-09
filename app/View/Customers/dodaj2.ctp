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
        <!-- <div class="col-md-1"></div> -->
        <div class="col-md-4">
            <div class="row">
                <?php 
                    echo $this->element('customers/contactAndNip', []);
                    //echo $this->element('customers/czasWalutaEtykieta', []); ?>
            </div>
            <div class="row">
                <?php //echo $this->element('customers/payments', []); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <?php echo $this->element('customers/czasWalutaEtykieta', []); ?>
        </div>
        <div class="col-md-4">
            <?php echo $this->element('customers/prepaid', []); ?>
        </div>
        <div class="col-md-3">
        </div>
        <?php
            //echo $this->element('customers/_czasWalutaEtykieta', []);
            echo $this->element('customers/opcje', []);
        ?>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <?php                
                    echo $this->element('customers/_contactNIP', []);
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row">
                <?php echo $this->element('customers/_payments', []); ?>
            </div>
        </div>
    </div>
</form>