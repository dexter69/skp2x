<?php 
//echo $this->App->print_r2($orders[4]['Order']);
//echo $this->App->print_r2($orders);
//echo count($orders); 
//echo microtime(true) - $time_start;
//$time_start2 = microtime(true);
//echo $par;

//if( $par == 'serwis') { echo count($orders); echo $this->App->print_r2($orders);}

$this->set('title_for_layout', 'Handlowe');
echo $this->Html->css(array('order', 'order/order-index.css?v=201811141223'), array('inline' => false));
//echo $this->Html->script(array('jquery', 'common'), array('inline' => false)); 
$this->Ma->displayActions('orders'); ?>

<div class="orders index">
    <?php // Nagłówek "HANDLOWE" + filtry obok
    echo $this->Ma->ordersIdxH2($par, $tylkoDlaSwoich); ?>    
    <table cellpadding="0" cellspacing="0" class="lista-handlowych">
    <tr>
        <th class="id"><?php echo $this->Paginator->sort('id'); ?></th>
        <th class="dolar"></th>
        <th class="nr"><?php echo $this->Paginator->sort('nr', 'Numer'); ?></th>      
        <!-- <th style="width: 60px;"></th> -->
        <th><?php echo $this->Paginator->sort('Customer.name', 'Klient'); ?></th> 
        <th class="job-info">Produkc.</th>
        <th class="termin"><?php echo $this->Paginator->sort('stop_day', 'Data zakończenia'); ?></th>
        <th class="status"><?php echo $this->Paginator->sort('status', 'STATUS'); ?></th>
        <th class="ebutt"></th>

    </tr>
    <?php
        foreach ($orders as $order) {
            // Jeżeli nie jest ustawiona (np. przy szukaniu serwisowych przez custom query)            
            if( !isset($order['Order']['servis']) ) {
                $order['Order']['servis'] = 0; // ustawiamy na "NIE"
            }
            if( !isset($order['Order']['ileJobs']) ) { // takie prymitywne obejścia
                $order['Order']['ileJobs'] = $order['Order']['idJoba'] = $order['Order']['nrJoba'] = 0; // ustawiamy na "NIE"
            }
            // Walnij jeden wiersz
            echo $this->element('orders/index/put-tr', ['order' => $order]);
        }            
    ?>   

    </table>
    <p>
    <?php
    echo $this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));	
    ?>	</p>
    <div class="paging"><?php
        echo $this->Paginator->prev('< ' . __('poprzedni'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('następny') . ' >', array(), null, array('class' => 'next disabled')); ?>
    </div>
</div>
<?php
//echo microtime(true) - $time_start2; 
//echo '<pre>'; print_r($orders); echo '</pre>';
?>












<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Dodaj Zamówienie'), array('action' => 'add')); ?></li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Dodaj Kartę'), array('controller' => 'cards', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Kart'), array('controller' => 'cards', 'action' => 'index')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Dodaj Klienta'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Klientów'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		
		
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>
-->