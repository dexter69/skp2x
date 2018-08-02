<?php
$this->set('title_for_layout', 'Nowy Klient');
$this->layout='bootstrap';
?>

<form class="row">    
    <div class="col-md-8">
        <?php echo $this->element('customers/adres', []);   ?>
    </div>
    <div class="col-md-4">
        <?php echo $this->element('customers/NIPitd', []);   ?>
    </div>
</form>


