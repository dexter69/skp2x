<?php
$this->set('title_for_layout', $customer['Customer']['name']);
//echo '<pre>'; echo print_r($customer); echo '</pre>';
//echo '<pre>'; echo print_r($inicjaly); echo '</pre>';
//echo '<pre>'; echo print_r($links); echo '</pre>';
//echo '<pre>'; echo print_r($orders_cards); echo '</pre>';
//echo '<pre>'; echo print_r($test); echo '</pre>';

$this->Html->css('customer', null, array('inline' => false));
$this->Ma->displayActions($links);
?>
<div class="customers view">
<h2><?php echo '<span>' . $customer['Customer']['name'] .'</span>'.$this->Ma->editlink('customer', $customer['Customer']['id']); ?></h2>
	<?php $this->Ma->nawiguj( $links, $customer['Customer']['id'] ); //nawigacyjne do dodaj, usuń, edycja itp. ?>
	<dl>
		<dt><?php echo 'Id'; ?></dt>
		<dd>
			<?php echo $customer['Customer']['id']; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Opiekun'; ?></dt>
		<dd>
			<?php //echo $this->Html->link($customer['Owner']['name'], array('controller' => 'users', 'action' => 'view', $customer['Owner']['id'])); 
				echo $customer['Owner']['name'];
			?>
			&nbsp;
		</dd>
		<dt><?php echo 'Nazwa'; ?></dt>
		<dd>
			<?php echo $customer['Customer']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pełna nazwa'); ?></dt>
		<dd>
			<?php echo h($customer['AdresSiedziby']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ulica'); ?></dt>
		<dd>
			<?php echo h($customer['AdresSiedziby']['ulica']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numer'); ?></dt>
		<dd>
			<?php echo h($customer['AdresSiedziby']['nr_budynku']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Miasto'); ?></dt>
		<dd>
			<?php echo h($customer['AdresSiedziby']['miasto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Kod pocztowy'); ?></dt>
		<dd>
			<?php echo h($customer['AdresSiedziby']['kod']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Kraj'); ?></dt>
		<dd>
			<?php echo h($customer['AdresSiedziby']['kraj']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Osoba Kontaktowa'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['osoba_kontaktowa']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telefon'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['tel']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('e-mail'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['email']); ?>
			&nbsp;
		</dd><!--
		<dt><?php echo __('Vatno'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['vatno']); ?>
			&nbsp;
		</dd>-->
		<dt><?php echo __('NIP'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['vatno_txt']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Waluta'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['waluta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Czas realizacji'; ?></dt>
		<dd><?php echo $customer['Customer']['cr'] . ' dni'; ?></dd>
		<?php //echo h($customer['Customer']['forma_zaliczki']); 
			if( $customer['Customer']['forma_zaliczki'] != BRAK) 
				echo '<dt>Forma Zaliczki</dt>';
			else
				echo '<dt>Zaliczka</dt>';
		?>
		<!--<dt><?php echo __('Forma Zaliczki'); ?></dt>-->
		<dd>
			
			<?php echo $vju['forma_zaliczki']['options'][$customer['Customer']['forma_zaliczki']]; ?>
			&nbsp;
		</dd>
		<?php
			if( $customer['Customer']['forma_zaliczki'] != BRAK) {
				echo '<dt>Procent Zaliczki</dt>';
				echo '<dd>'.h($customer['Customer']['procent_zaliczki']).'&nbsp'.'</dd>';
			}
				
		?>
		<!--
		<dt><?php echo __('Procent Zaliczki'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['procent_zaliczki']); ?>
			&nbsp;
		</dd>-->
		<dt><?php echo __('Forma Płatności'); ?></dt>
		<dd>
			<?php //echo h($customer['Customer']['forma_platnosci']); ?>
			<?php echo $vju['forma_platnosci']['options'][$customer['Customer']['forma_platnosci']]; ?>
			&nbsp;
		</dd>
		<?php
			if( $customer['Customer']['forma_platnosci'] == PRZE || $customer['Customer']['forma_platnosci'] == CASH )
				echo '<dt>Termin Płatności</dt><dd>' . $customer['Customer']['termin_platnosci'] . ' dni</dd>'; 
		?>
		<!--
		<dt><?php echo __('Stworzone'); ?></dt>
		<dd>
			<?php echo $this->Ma->mdt($customer['Customer']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zmodyfikowane'); ?></dt>
		<dd>
			<?php echo $this->Ma->mdt($customer['Customer']['modified']); ?>
			&nbsp;
		</dd>  -->
                <dt><?php echo 'Uwagi'; ?></dt>
		<dd>
			<?php echo nl2br($customer['Customer']['comment']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related klient-zamowienia-karty">
    <h3>Zamówienia</h3>
    <?php
        //echo $this->Ma->relatedCustomerOrders($customer['Order'], $customer['Card'], $inicjaly);
    ?>
</div>

