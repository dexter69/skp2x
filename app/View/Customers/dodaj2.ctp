<?php
$this->set('title_for_layout', 'Nowy Klient');
$this->layout='bootstrap';
?>

<form>
    <div class="row">
        <div class="col-md-9">
            <?php echo $this->element('customers/kolumna1', []); ?>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <?php echo $this->element('customers/kolumna2', []); ?>
        </div>
    </div>
</form>