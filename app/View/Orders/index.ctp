<?php 
//echo '<pre>'; print_r($orders); echo '</pre>';
//echo count($orders); 
//echo microtime(true) - $time_start;
//$time_start2 = microtime(true);
//echo $par;
$this->set('title_for_layout', 'Handlowe');
echo $this->Html->css(array('order', 'order/order-index.css?v=' . time(), 'font-awesome-4.6.1/css/font-awesome.min'), array('inline' => false));
//echo $this->Html->script(array('jquery', 'common'), array('inline' => false)); 
$this->Ma->displayActions('orders');
$klasa = array(
	'my'=>null, 'accepted'=>null, 'rejected'=>null,
	'wait4check'=>null,	'active'=>null,	'closed'=>null,
	'today'=>null, 'wszystkie'=>null 
);
if( $par == null || $par == 'all-but-priv')
	$klasa['wszystkie'] = 'swieci';
else
	$klasa[$par] = 'swieci';
?>

<div class="orders index">
    <h2 class="hfiltry"><div><?php echo 'HANDLOWE</div>'; 
            echo $this->Ma->indexFiltry('orders', $klasa);
    ?>

    </h2>
    <table cellpadding="0" cellspacing="0" class="lista-handlowych">
    <tr>
        <th class="id"><?php echo $this->Paginator->sort('id'); ?></th>
        <th class="dolar"></th>
        <th class="nr"><?php echo $this->Paginator->sort('nr', 'Numer'); ?></th>            
        <th><?php echo $this->Paginator->sort('Customer.name', 'Klient'); ?></th>            
        <th class="termin"><?php echo $this->Paginator->sort('stop_day', 'Data zakończenia'); ?></th>
        <th class="status"><?php echo $this->Paginator->sort('status', 'STATUS'); ?></th>
        <th class="ebutt"></th>

    </tr>
    <?php foreach ($orders as $order): ?>
    <tr>
            <td class="idcolnobold id"><?php
                echo $this->Html->link( $order['Order']['id'], array('action' => 'view', $order['Order']['id'])); ?>
            &nbsp;</td>
            <?php 
                $klasaDolara = $this->Ma->klasaDolara($order['Order']['forma_zaliczki'], $order['Order']['stan_zaliczki']); ?>
            <td class="<?php echo $klasaDolara ?>"><i class="fa fa-usd" aria-hidden="true"></i></td>            
            <td class="nr"><?php 
                echo $this->Html->link(
                    $this->Ma->bnr2nrh($order['Order']['nr'], $order['User']['inic']),
                    array('action' => 'view', $order['Order']['id']),
                    array('escape' => false)
                ); ?>
            </td>
            <td>
                    <?php echo $this->Html->link($order['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $order['Customer']['id']), array('title' => $order['Customer']['name'])); ?>
            </td>            
            <td class="termin"><?php echo $this->Ma->md($order['Order']['stop_day']); ?>&nbsp;</td>

            <td class="status"><?php echo $this->Ma->status_zamow( $order['Order']['status'] ); ?>&nbsp;</td>

            <td class="ebutt"><?php echo $this->Html->link('<div></div>', array('action' => 'edit', $order['Order']['id']), array('class' => 'ebutt',  'escape' =>false)); ?></td>


    </tr>
<?php endforeach; ?>
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