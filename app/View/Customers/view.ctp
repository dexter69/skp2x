<?php
$this->set('title_for_layout', $customer['Customer']['name']);
$this->layout='bootstrap';
echo $this->Html->css('boot/customer', null, array('inline' => false));
//echo count($customer['Order']) . "<br>";
//echo count($customer['Card']) . "<br>";
//echo DS . '<br>'; //echo LIN . '<br>'; //echo WIN;
//if( DS == LIN ) { echo 'We are on Linux!'; } 
//if( DS == WIN ){ echo 'We are on Windows!'; }
//echo $this->webroot;
/*
 *  dfksdfk
 */
?>

<div class="row">
    <div class="col-md-12">
        <!--<span class="label label-default label-big">Klient:</span>-->
        <h1 class="object-title"> 
            <?php 
                echo $customer['Customer']['name']; 
                echo $this->BootHtml->customerEditGlyph( $customer['Customer']['id'] );
            ?>            
        </h1>
        <ul class="nav nav-pills customer-pills f15">
            <li role="presentation" class="active"><a href="#profile" data-toggle="tab"><strong>Dane klienta</strong></a></li>
            <li role="presentation"><a href="#zamowienia" data-toggle="tab"><strong>Zamówienia</strong></a></li>
            <li role="presentation"><a href="#karty" data-toggle="tab"><strong>Karty</strong></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="profile">
              <?php 
                $dane = array(
                    'customer' => $customer['Customer'],
                    'siedziba' => $customer['AdresSiedziby'],
                    'opiekun' => $customer['Owner']['name']
                );
                echo $this->element('customers/profil', $dane); ?>
            </div>
            <div class="tab-pane fade" id="zamowienia">
                <?php echo $this->BootHtml->tableOfOrders4Customer($customer['Order'], $customer['User']); ?>
            </div>
            <div class="tab-pane fade" id="karty">
              <?php echo $this->BootHtml->tableOfCards4Customer($customer['Card'], $customer['User']); ?>
            </div>            
        </div>
    </div>        
</div>
<?php
//echo '<pre>'; echo print_r($customer['Card']); echo '</pre>';