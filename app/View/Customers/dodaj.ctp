<?php
$this->set('title_for_layout', 'Nowy Klient');
$this->layout='bootstrap';
?>

<form>
    <div class="row">
    <?php echo $this->element('customers/nazwaNipWaluta', []); ?>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?php echo $this->element('customers/adres', []); ?>
        </div>
        <div class="col-md-4">
            <?php echo $this->element('customers/NIPitd', []);   ?>
        </div>
    </div>
    <div class="row">        
        <?php echo $this->element('customers/kontakt', []);   ?>                     
    </div>
</form>


