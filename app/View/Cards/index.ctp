<?php 
    echo $this->Html->css('card.css?v=3289976734', null, array('inline' => false));
    echo $this->Ma->walnijJqueryUI();
    echo $this->Ma->jqueryUItoolTip('.process, #karty td');
    echo $this->Html->script(array('card-perso'), array('block' => 'scriptBottom'));
    $jscode = 'var theurl = "' . $this->Html->url(array('action' => 'addCzasPerso', 'ext' => 'json')) . '";';
    echo $this->Html->scriptBlock($jscode, array('inline' => false));
   
    $this->set('title_for_layout', 'Karty');

    //echo '<pre>'; print_r($cards); echo '</pre>';
    //echo 'Szukano: ' . '<b>'.$gibon.'</b>';

    //echo $this->Html->url(array('action' => 'addCzasPerso', 'ext' => 'json'));
	
$klasa = array(	'dtpcheck'=>null, 'persocheck'=>null, 'all-but-priv'=>null,
		'my'=>null, 'active'=>null, 'closed'=>null, 'ponly'=>null,
                'pover'=>null, 'ptodo'=>null);
if( array_key_exists($par, $klasa) )
    { $klasa[$par] = 'swieci'; }
?>

<div id="indekskart" class="cards index">
	<h2 class="hfiltry"><?php echo 'KARTY'; 
		echo $this->Ma->indexFiltry('cards', $klasa);
	?>
		
	</h2>
	<table id="karty" cellpadding="0" cellspacing="0">
	<tr>
            <th class="id"><?php echo $this->Paginator->sort('id'); ?></th>
            <th class="per"></th>
            <th class="nazwa"><?php echo $this->Paginator->sort('name','Nazwa karty'); ?></th>
            <th class="opcje">Opcje</th>
            <th class="nr"><?php echo $this->Paginator->sort('Order.nr', 'Handlowe'); ?></th>
            <th class="nr"><?php echo $this->Paginator->sort('job_id', 'Produk.'); ?></th>
            <th class="termin"><?php 
                if( $cards['pvis'] ) {
                    echo 'Czas';
                } else {
                    echo $this->Paginator->sort('Order.stop_day', 'Czas');
                } ?>
            </th>
            <!--<th class="klient"><?php //echo $this->Paginator->sort('customer_id', 'Klient'); ?></th>
            -->
            
            <th class="ile"><?php echo $this->Paginator->sort('quantity', 'Ilość'); ?></th>
            <th class="status"><?php echo $this->Paginator->sort('status'); ?></th>
            <th class="ebutt"></th><!--
            <th><?php echo $this->Paginator->sort('price'); ?></th>
            <th><?php echo $this->Paginator->sort('wzor'); ?></th>--><!--
            <th><?php echo $this->Paginator->sort('comment'); ?></th>

            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th><?php echo $this->Paginator->sort('modified'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>-->
	</tr>
	<?php $i=0; $pvis = $cards['pvis']; unset($cards['pvis']);
            foreach ($cards as $card): ?>
	<tr>
		<td class="id"><?php echo $card['Card']['id']; ?>&nbsp;</td>
                <?php
                    $klasa = null;
                    if( $card['Card']['isperso'] ) {
                        $klasa = ' jest';
                        if( $card['Card']['status'] == KONEC || $card['Card']['pover'] ) {
                            $klasa = ' pover';
                        }                       
                    } 
                ?>
                <td class="per<?php echo $klasa ?>"></td>
		<!--<td><?php echo h($card['Card']['name']); ?>&nbsp;</td>-->
		<td class="nazwa">
			<?php echo $this->Html->link($card['Card']['name'], array('action' => 'view', $card['Card']['id']), array('title' => $card['Card']['name'])); ?>
		</td>
                <td class="opcje">
                    <?php 
                        //echo $this->Html->link($card['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $card['Customer']['id'])); 
                        echo $this->Ma->cechyKarty( $card['Card'], 'indeks' );
                    ?>
		</td>
		<td class="nr">
                    <?php 
                        if( $card['Order']['id'] ) 
                            if( $card['Order']['nr'] )
                                    echo $this->Html->link($this->Ma->bnr2nrh($card['Order']['nr'], $card['Creator']['inic']), array('controller' => 'orders', 'action' => 'view', $card['Order']['id']), array('escape' => false)); 
                            else
                                    echo $this->Html->link($card['Order']['id'], array('controller' => 'orders', 'action' => 'view', $card['Order']['id'])); 					
                    ?>
		</td>
		<td class="nr">
			<?php //echo $this->Html->link($card['Job']['id'], array('controller' => 'jobs', 'action' => 'view', $card['Job']['id'])); ?>
			<?php
                            if( $card['Job']['nr'] )
                                echo $this->Html->link($this->Ma->bnr2nrj($card['Job']['nr'], null),
                                        array('controller' => 'jobs', 'action' => 'view', $card['Job']['id']), array('escape' => false)
                                ); 
                            else
                                echo $this->Html->link($card['Job']['id'], array('controller' => 'jobs', 'action' => 'view', $card['Job']['id']));
			?>
		</td>
                <?php
                    //$cards['upc']
                    $klasa = 'termin wyroznij-date';
                    $title = null;
                    if( $pvis && $card['Card']['stop_perso']) { 
                    // zalogowany użytkownik -> perso date i data perso ustawiona
                        $data = $card['Card']['stop_perso'];
                        if (isset( $card['Card']['pdate']) ) {
                            $klasa .= ' persodate';
                            $title = ' title="' . $this->Ma->mdvs($card['Order']['stop_day']) . '"';
                        } 
                    } else {                                                
                        $data = $card['Order']['stop_day'];
                    }
                    $datka = $this->Ma->mdvs($data);
                    if( $pvis && $this->Ma->stanPersoChange( $card['Card'] ) ) {
                    // jeżeli można zmieniać datę perso    
                        $klasa .=  ' changable';                        
                    }
		?>
		<td
                    class="<?php echo $klasa; ?>"
                    <?php echo $title; ?>
                    data-id="<?php echo $card['Card']['id']; ?>"
                    data-termin="<?php echo $data; ?>"
                    >
                    <?php echo $datka; ?>
		</td>
		
		
		<td class="ile"><?php if( $card['Card']['ilosc'] )
				echo $this->Ma->tys($card['Card']['ilosc']*$card['Card']['mnoznik']); ?>&nbsp;</td>
		<!--<td><?php echo h($card['Card']['status']); ?>&nbsp;</td>-->
		<td class="status"><?php 
			if( $card['Card']['status'] == PRIV && $card['Order']['id'] ) 
				echo 'ZAŁĄCZ.';
			else
				echo $this->Ma->status_karty($card['Card']['status'], true); ?>&nbsp;
		</td>
		<td class="ebutt"><?php echo $this->Html->link('<div></div>', array('action' => 'edit', $card['Card']['id']), array('class' => 'ebutt',  'escape' =>false)); ?></td>
		<!--
		<td><?php echo h($card['Card']['price']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['wzor']); ?>&nbsp;</td>--><!--
		<td><?php echo h($card['Card']['comment']); ?>&nbsp;</td>
		
		<td><?php echo h($card['Card']['created']); ?>&nbsp;</td>
		<td><?php echo h($card['Card']['modified']); ?>&nbsp;</td>--><!--
		
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $card['Card']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $card['Card']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $card['Card']['id']), null, __('Are you sure you want to delete # %s?', $card['Card']['id'])); ?>
		</td>-->
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Strona {:page} z {:pages}, pokazująca {:current} wpisów z {:count} wszystkich, zaczynając od rekordu {:start}, kończąc na {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

<!-- Do zmieniania daty perso -->

<div id="datepicker"></div><div id="komunikat"></div>

<?php $this->Ma->displayActions('cards'); ?>

<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Dodaj Kartę'), array('action' => 'add')); ?></li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Dodaj Zamówienie'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Zamówień'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Dodaj Klienta'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Klientów'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('Dodaj Zlecenie'), array('controller' => 'jobs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Zleceń'), array('controller' => 'jobs', 'action' => 'index')); ?> </li>
		<li class="prw"></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		
		
		
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>

-->

<!--  <script>
    $(function() {
      $( '.process' ).tooltip();
    });
  </script>-->
