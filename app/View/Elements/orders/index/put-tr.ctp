<!-- Machnij jeden wiersz tabeli -->
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
    <td style="width: 60px; color: red;"><?php echo $order['Order']['servis'] ? "TAK" : "" ?></td>
    <td>
            <?php echo $this->Html->link($order['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $order['Customer']['id']), array('title' => $order['Customer']['name'])); ?>
    </td>     
    <td class="job-info">
        <?php                
        if( $order['Order']['ileJobs'] ) { // Jezeli handlowe jest powiązane przynajmniej z 1 handlowym
            if( $order['Order']['ileJobs'] > 1 ) { // wiecej niż 1 job
                $suffix = " +";
            } else {
                $suffix = "";
            }
            echo $this->Html->link(
                $this->App->bnr2nrj($order['Order']['nrJoba'], null) . $suffix,
                [
                    'controller' => 'jobs',
                    'action' => 'view',
                    $order['Order']['idJoba']
                ],
                ['escape' => false]
            );
        }
        ?>
    </td>   
    <td class="termin"><?php echo $this->Ma->md($order['Order']['stop_day']); ?>&nbsp;</td>

    <td class="status"><?php echo $this->Ma->status_zamow( $order['Order']['status'] ); ?>&nbsp;</td>

    <td class="ebutt"><?php echo $this->Html->link('<div></div>', array('action' => 'edit', $order['Order']['id']), array('class' => 'ebutt',  'escape' =>false)); ?></td>


    </tr>