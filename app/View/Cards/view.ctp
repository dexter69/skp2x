<?php 
//echo '<pre>';	print_r($juzer); echo  '</pre>'; 

//echo '<pre>';	print_r($buttons); echo  '</pre>'; 
//echo '<pre>';	print_r($bcontr); echo  '</pre>'; 
//echo '<pre>';	print_r($evcontrol); echo  '</pre>';
//echo '<pre>';	print_r($links); echo  '</pre>'; 
//echo '<pre>';	print_r($card); echo  '</pre>'; 
//
//echo '<pre>';	print_r($vju['x_sito']['options']); echo  '</pre>'; 

echo $this->Html->css('card.css?v=328496968', null, array('inline' => false));
echo $this->Html->script(array('event'), array('inline' => false)); 
echo $this->Ma->walnijJqueryUI();
echo $this->Ma->jqueryUItoolTip('.process, .persodate');
echo $this->Html->script(array('card-perso'), array('block' => 'scriptBottom'));

$this->set('title_for_layout', $card['Card']['name']);

$this->Ma->displayActions('cards');


//echo '<pre>';	print_r($card['Card']); echo  '</pre>'; 
//echo $this->Ma->cechyKarty( $card['Card'] );
//echo '<pre>';	print_r($this->Ma->tablica_cech); echo  '</pre>'; 
//if( $this->Ma->tablica_cech['isperso'] ) echo 'Gibon';

?>



<div id="kartview" class="cards view">
<h2><?php 	//echo '<p>Oglądasz kartę</p>'; 
        echo '<span>'.$card['Card']['name'].'</span>' . 
        $this->Ma->editlink('card', $card['Card']['id']); 
        echo $this->Ma->cechyKarty( $card['Card'], 'wju' );
        ?>
</h2>
	<?php $this->Ma->nawiguj( $links, $card['Card']['id'] ); //nawigacyjne do dodaj, usuń, edycja itp. ?>
	<dl id="cardviewdl">
		<dt><?php echo 'Id'; ?></dt>
		<dd>
			<?php echo $card['Card']['id']; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Nazwa karty'; ?></dt>
		<dd>
			<?php echo $card['Card']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Termin'; ?></dt>    
                <?php
                    if( $card['Card']['pvis'] && $card['Card']['stop_perso']) { 
                    // zalogowany użytkownik -> perso date i data perso ustawiona
                        $klasa = 'termin wyroznij_date persodate';
                        $title = ' title="' . $this->Ma->md($card['Order']['stop_day']) . '"';
                        $data = $card['Card']['stop_perso'];
                        //$datka = $this->Ma->md($card['Card']['stop_perso']);
                    } else {
                        $klasa = 'termin wyroznij_date';
                        $title = null;
                        $data = $card['Order']['stop_day'];
                        //$datka = $this->Ma->md($card['Order']['stop_day']);
                    }
                    $datka = $this->Ma->md($data);
                    if( $card['Card']['pvis'] && $this->Ma->stanPersoChange( $card['Card'] ) ) {
                    // jeżeli można zmieniać datę perso    
                        $klasa .=  ' changable';
                    }
                ?>
		<dd
                    class="<?php echo $klasa ?>"
                    <?php echo $title ?>
                    data-id="<?php echo $card['Card']['id']; ?>"
                    data-termin="<?php echo $data; ?>"
                    >
			<?php echo $datka; ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Klient'; ?></dt>
		<dd>
			<?php echo $this->Html->link($card['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $card['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Opiekun'; ?></dt>
		<dd>
			<?php 
				//echo $this->Html->link($card['Owner']['name'], array('controller' => 'users', 'action' => 'view', $card['Owner']['id'])); 
				echo $card['Owner']['name'];
			?>
			&nbsp;
		</dd>
		<dt><?php echo 'Zamówienie (H)'; ?></dt>
		<dd>
			<?php
				if( $card['Order']['id'] ) 
					if( $card['Order']['nr'] )
						echo $this->Html->link($this->Ma->bnr2nrh($card['Order']['nr'], $card['Creator']['inic']), array('controller' => 'orders', 'action' => 'view', $card['Order']['id']), array('escape' => false)); 
					else
						echo $this->Html->link('id = '.$card['Order']['id'], array('controller' => 'orders', 'action' => 'view', $card['Order']['id'])); 
			?>
			&nbsp;
		</dd>
		<dt><?php echo 'Zlecenie (P)'; ?></dt>
		<dd>
			<?php 
					if( $card['Job']['nr'] )
						echo $this->Html->link( $this->Ma->bnr2nrj($card['Job']['nr'],null), array('controller' => 'jobs', 'action' => 'view', $card['Job']['id']), array('escape' => false));
					else						
						echo $this->Html->link($card['Job']['id'], array('controller' => 'jobs', 'action' => 'view', $card['Job']['id'])); ?>
			&nbsp;
		</dd>
		
		
		<dt><?php echo 'Cena'; ?></dt>
		<dd>
			<?php echo $this->Ma->colon($card['Card']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Ilość'; ?></dt>
		<dd>
			<?php if( $card['Card']['ilosc'] )
					echo $this->Ma->tys($card['Card']['ilosc']*$card['Card']['mnoznik']); ?>
			&nbsp;
		</dd>
		
		
		<dt><?php echo 'Status'; ?></dt>
		<dd>
			<?php 
				if( $card['Card']['status'] == PRIV && $card['Order']['id'] )
					echo 'ZAŁĄCZONA';
				else
					echo $this->Ma->status_karty($card['Card']['status']);
			?>
			&nbsp;
		</dd>
		<dt><?php echo 'Stworzone'; ?></dt>
		<dd>
			<?php echo $this->Ma->mdt($card['Card']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo 'Zmodyfikowane'; ?></dt>
		<dd>
			<?php echo $this->Ma->mdt($card['Card']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
	
<div id="cmykwrap">
	<?php echo $this->Ma->viewheader('MATERIAŁ, KOLORYSTYKA'); ?>
	<table id="cardcmyk" class="cardviewtable">
	<?php
	$cells[] = array('materiał', $vju['x_material']['options'][$card['Card']['a_material']], $vju['x_material']['options'][$card['Card']['r_material']]);
	//if( $card['Card']['a_lam'] || $card['Card']['r_lam'] )
		$cells[] = array('laminat', $vju['x_lam']['options'][$card['Card']['a_lam']], $vju['x_lam']['options'][$card['Card']['r_lam']]);
	$cells[] = array('cmyk',
	 	$vju['x_c']['options'][$card['Card']['a_c']].
	 	$vju['x_m']['options'][$card['Card']['a_m']].
	 	$vju['x_y']['options'][$card['Card']['a_y']].
	 	$vju['x_k']['options'][$card['Card']['a_k']],
	 	$vju['x_c']['options'][$card['Card']['r_c']].
	 	$vju['x_m']['options'][$card['Card']['r_m']].
	 	$vju['x_y']['options'][$card['Card']['r_y']].
	 	$vju['x_k']['options'][$card['Card']['r_k']]
	 );
	 if( $card['Card']['a_pant'] || $card['Card']['r_pant'] )
		$cells[] = array('pantony', $card['Card']['a_pant'],  $card['Card']['r_pant']);
	echo $this->Html->tableHeaders(array('', 'awers', 'rewers'));
	echo $this->Html->tableCells($cells);
	?>
	</table>
	<?php 
		if( $card['Card']['cmyk_comment'] )
			echo '<div class="smallcomment"><p>uwagi (materiał, kolorystyka):</p>'.nl2br($card['Card']['cmyk_comment']).'</div>'; 
	?>
</div>		
<!--<div style="clear: both;"></div>-->

	<?php
		//jeżeli karta ma jakies opcje sita to wyświetl tabelę
		$cells = array();
		if( $card['Card']['a_podklad'] || $card['Card']['r_podklad'] ) {
			$cells[] = array('podkład',
				$vju['x_sito']['options'][$card['Card']['a_podklad']],
				$vju['x_sito']['options'][$card['Card']['r_podklad']]
			);
			$cells[] = array('wybranie',
				$vju['yesno']['options'][$card['Card']['a_wybr']],
				$vju['yesno']['options'][$card['Card']['r_wybr']]
			);
		}
		if( $card['Card']['a_zadruk'] || $card['Card']['r_zadruk'] ) 
			$cells[] = array('zadruk',
				$vju['x_sito']['options'][$card['Card']['a_zadruk']],
				$vju['x_sito']['options'][$card['Card']['r_zadruk']]
			);
		if( $card['Card']['a_podpis'] || $card['Card']['r_podpis'] ) 
			$cells[] = array('pasek do pod.',
				$this->Ma->card_view['x_podpis']['view'][$card['Card']['a_podpis']],
				$this->Ma->card_view['x_podpis']['view'][$card['Card']['r_podpis']]
			);
		if( $card['Card']['a_zdrapka'] || $card['Card']['r_zdrapka'] )
			$cells[] = array('zdrapka',
					$vju['yesno']['options'][$card['Card']['a_zdrapka']],
					$vju['yesno']['options'][$card['Card']['r_zdrapka']]
			); 
		if( $card['Card']['a_lakpuch'] || $card['Card']['r_lakpuch'] )
			$cells[] = array('lakier puchnący',
					$vju['yesno']['options'][$card['Card']['a_lakpuch']],
					$vju['yesno']['options'][$card['Card']['r_lakpuch']]
			); 
		if( $card['Card']['a_lakblys'] || $card['Card']['r_lakblys'] )
			$cells[] = array('lakier błyszczący',
					$vju['yesno']['options'][$card['Card']['a_lakblys']],
					$vju['yesno']['options'][$card['Card']['r_lakblys']]
			); 
		if( !empty($cells) ) {
			
			echo $this->Ma->viewheader('OPCJE SITA', array('class' => 'masymetric'));
			echo $this->Html->tag('table', null, array('id' => 'cardsito', 'class' => 'cardviewtable'));
			echo $this->Html->tableHeaders(array('', 'awers', 'rewers'));
			echo $this->Html->tableCells($cells);
			echo $this->Html->tag('/table');
			echo '<div class="smallcomment"><p>uwagi:</p>'.nl2br($card['Card']['sito_comment']).'</div>'; 
		}
		$inne = null;
		if( $card['Card']['mag'] ) {
			$inne .= $this->Html->tag('dt', 'pasek mag.', null);
			$inne .= $this->Html->tag('dd', $vju['mag']['options'][$card['Card']['mag']], null);
		}
		if( $card['Card']['chip'] ) {	
			$inne .= $this->Html->tag('dt', 'chip', null);
			$inne .= $this->Html->tag('dd', $vju['chip']['options'][$card['Card']['chip']], null);
		}
		if( $card['Card']['dziurka'] ) {	
			$inne .= $this->Html->tag('dt', 'dziurka', null);
			$inne .= $this->Html->tag('dd', $vju['dziurka']['options'][$card['Card']['dziurka']], null);
		}
		if( $card['Card']['ksztalt'] ) {	
			$inne .= $this->Html->tag('dt', 'kształt', null);
			$inne .= $this->Html->tag('dd', $vju['ksztalt']['options'][$card['Card']['ksztalt']], null);
		}
		if( $card['Card']['hologram'] ) {	
			$inne .= $this->Html->tag('dt', 'hologram', null);
			$inne .= $this->Html->tag('dd', $vju['hologram']['options'][$card['Card']['hologram']], null);
		}
                if( $card['Card']['wzor'] ) {	
			$inne .= $this->Html->tag('dt', 'Wzory / załączniki', null);
			$inne .= $this->Html->tag('dd', $vju['wzor']['options'][$card['Card']['wzor']], null);
		}
		$isperso = $card['Card']['isperso'];
		if( !$inne && $isperso ) {
			$startdiv1 = $this->Html->tag('div', null, array('id' => 'perop1'));	
			$startdiv2 = $this->Html->tag('div', null, array('id' => 'perop2'));	
			$stopdiv = $this->Html->tag('/div');
		} else
		{	$startdiv1 = $startdiv2 = $stopdiv = null; }
		echo '<div style="clear: both"></div>'; 
		if( $isperso ) {
                    $klasa = null;
                    if( $card['Card']['status'] == KONEC || $card['Card']['pover'] ) {
                       $klasa = ' pover-view';
                    }
                    $peropcje = null;
                    if( $card['Card']['pl'] + $card['Card']['pt'] + $card['Card']['pe'] ) {
                    // czyli są zaznaczone jakieś opcje
                        $peropcje = 
                        $this->Ma->perso3opcje['podlam-span'][$card['Card']['pl']] .
                        $this->Ma->perso3opcje['plaska-span'][$card['Card']['pt']] .
                        $this->Ma->perso3opcje['emboss-span'][$card['Card']['pe']];
                    }
                    echo $startdiv1;
                    echo $this->Ma->viewheader('PERSONALIZACJA' . $peropcje, array('class' => 'margingor'));
                    echo $this->Html->tag('p', nl2br($card['Card']['perso']), array('class' => 'comments' . $klasa));	
                    echo $stopdiv;
		}
		if( $inne ) {
			echo $startdiv2;
			echo $this->Ma->viewheader('INNE OPCJE', array('class' => 'masymetric'));
			echo $this->Html->tag('dl', null, array('id' => 'innedl'));
			echo $inne;
			echo $this->Html->tag('/dl');
			echo '<div class="smallcomment"><p>uwagi:</p>'.nl2br($card['Card']['option_comment']).'</div>'; 
			echo $stopdiv;
		}
		if( !empty($card['Card']['comment']) ) { //UWAGI KOŃCOWE
			echo $this->Ma->viewheader('UWAGI DO CAŁOŚCI:');
			echo $this->Html->tag('p', nl2br($card['Card']['comment']), array('class' => 'comments'));	
			//echo $card['Card']['comment'];
		}
	?>
	
	<?php if (!empty($card['Upload'])): ?>
	<div class="related">
	<?php echo $this->Ma->viewheader('ZAŁĄCZONE PLIKI', array('class' => 'masymetric')); ?>
	
	
	<table id="plikikarty" cellpadding = "0" cellspacing = "0">
	<tr>
		<th class="id"><?php echo 'Id'; ?></th><!--
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Description'); ?></th>-->
		<th class="filename"><?php echo 'Nazwa Pliku'; ?></th>
		<th class="rola"><?php echo __('Przeznaczenie'); ?></th>
		<th class="size"><?php echo 'Rozmiar'; ?></th>
		<th class="data"><?php echo 'Data'; ?></th><!--
		<th><?php echo __('Filemime'); ?></th>
		<th><?php echo __('Created'); ?></th>
		
		<th class="actions"><?php echo __('Actions'); ?></th>-->
	</tr>
	<?php foreach ($card['Upload'] as $upload): ?>
		<tr>
			<td class="id"><?php echo $upload['id']; ?></td><!--
			<td><?php echo $upload['title']; ?></td>
			<td><?php echo $upload['description']; ?></td>-->
			
			<td class="filename"><?php
			/* Pierwsze rozwiązanie, dane idą do url
			$uuidname = $upload['uuidname'];
			$filemime = $upload['filemime'];
			$pos = strpos($filemime, '/');
			$filemime1 = substr($filemime, 0, $pos);
			$filemime2 = substr($filemime, $pos+1);
			echo $this->Html->link( $upload['filename'], array('controller' => 'uploads', 'action' => 'download', $uuidname, $upload['filename'], $filemime1, $filemime2 ) );
			*/
			echo $this->Html->link( $upload['filename'], array('controller' => 'uploads', 'action' => 'download', $upload['id'] ) );
			?>
				
			</td>
			<td class="rola"><?php echo $upload['roletxt']; ?></td>
			<td class="size"><?php 
				if( $upload['filesize'] < KILO ) {
					echo $upload['filesize'] . ' B';
				}
				elseif ( $upload['filesize'] < MEGA ) {
					echo $this->Ma->colon(strval(round($upload['filesize'] / KILO, 2)), 2) . ' kB'; 
				}
				else {
					echo $this->Ma->colon(strval( round($upload['filesize'] / MEGA, 2) ), 2) . ' MB'; 
				}
					
			?></td>
			<td class="data"><?php echo substr($upload['created'],0,10); ?></td><!--
			<td><?php echo $upload['filemime']; ?></td>
			<td><?php echo $upload['created']; ?></td>
			-->
			<!--
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'uploads', 'action' => 'view', $upload['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'uploads', 'action' => 'edit', $upload['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'uploads', 'action' => 'delete', $upload['id']), null, __('Are you sure you want to delete # %s?', $upload['id'])); ?>
			</td>-->
		</tr>
	<?php endforeach; ?>
	</table>
	

	
	</div>
	<?php endif; ?>

</div>

<!-- Do zmieniania daty perso -->
<div id="datepicker"></div><div id="komunikat"></div>

<?php $this->Ma->kontrolka($card, $evcontrol);	?>	




