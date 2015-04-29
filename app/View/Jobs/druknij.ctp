<?php
	echo $this->Html->css('printjob', null, array('inline' => false));
	//echo '<pre>';	print_r($job); echo  '</pre>';
?>

<div id="tablewrap">
<table id="jobsumarum" cellpadding = "0" cellspacing = "0">
	<tr>
		<td id="nrjob" ><?php echo $this->Ma->bnr2nrj($job['Job']['nr'], null); ?></td>
		<td><?php  ?></td>
		<td>Data zakończenia:</td>
		<td class="redoza"><?php echo $this->Ma->md($job['Job']['stop_day']); ?></td>
	</tr>
	<tr>
		<td>Rodzaj arkusza:</td>
		<td class="gruby"><?php echo $this->Ma->arkusz[$job['Job']['rodzaj_arkusza']]; ?></td>
		<td>Data przyjęcia:</td>
		<td><?php  ?></td>
	</tr>
	<tr>
		<td>Zwyżka dla offsetu</td>
		<td class="gruby"><?php echo h($job['Job']['dla_drukarzy']); ?></td>
		<td>Arkusze do laminacji</td>
		<td class="redoza"><?php echo $this->Ma->tys($job['Job']['dla_laminacji']); ?></td>
	</tr>
	
	
</table>
</div>
<div id="uwagoza"><span>Uwagi:</span><?php echo nl2br(h($job['Job']['comment'])); ?></div>

<div class="related">
	
	<?php if (!empty($job['Card'])): ?>
	<table id="print_job_cards" cellpadding = "0" cellspacing = "0">
	<tr>
		<th class="karta">KARTA</th>
		<th>KLIENT</th>
		<th class="ile">ILOŚĆ</th>
		<th class="materia">MATERIA</th>
		<th class="siprze">SITO<br/>przed</th>
		<th class="wynie">WYBRA<br/>NIE?</th>
		<th class="cmyk">CMYK</th>		
		<th class="lam">LAMINAT</th>
		<th class="sipo">SITO<br/>po</th>
		<th class="mag">MAG.</th>
		<th class="pasek">PASEK<br/>PODP.</th>
		<th class="perso">PER<br/>SON</th>
	</tr>
	<?php foreach ($job['Card'] as $card): ?>
		<tr>
			<td class="gruby karta"><?php echo $card['name']; ?></td>
			<td><?php echo $ordery[$card['id']]['Customer']['name']; ?></td>
			<td class="ile"><?php echo $this->Ma->tys($card['quantity']); ?></td>
			<td class="materia"><?php 
				$coptions['x_material']['options'][1] = 'PVC';
				echo
				substr($coptions['x_material']['options'][$card['a_material']],0,3).'/'.
				substr($coptions['x_material']['options'][$card['r_material']],0,3);
			?></td>
			<td class="siprze"><?php
				if( $card['a_podklad'] || $card['r_podklad'] ) echo '+'; else echo '-';				 
			?></td>
			
			<td class="wynie"><?php 
				if( $card['a_wybr'] || $card['r_wybr'] ) echo '+'; else echo '-';			
			?></td>
			<td class="waski cmyk"><?php 
			//echo $ordery[$card['id']]['User']['name'];
			echo 
			$coptions['x_c']['options'][$card['a_c']].
			$coptions['x_m']['options'][$card['a_m']].
			$coptions['x_y']['options'][$card['a_y']].
			$coptions['x_k']['options'][$card['a_k']].'/'.
			$coptions['x_c']['options'][$card['r_c']].
			$coptions['x_m']['options'][$card['r_m']].
			$coptions['x_y']['options'][$card['r_y']].
			$coptions['x_k']['options'][$card['r_k']];
			?></td>
			
			<td class="waski lam"><?php echo 
			substr($coptions['x_lam']['options'][$card['a_lam']],0,5)
			.'/'.
			substr($coptions['x_lam']['options'][$card['r_lam']],0,5);
			?></td>
			<td class="sipo"><?php 
			if( $card['a_zdrapka'] || $card['r_zdrapka'] || $card['a_lakpuch'] || 
                            $card['r_lakpuch'] || $card['a_lakblys'] || $card['r_lakblys'] 
                          ) 
                                {echo '+'; } 
                        else    { echo '-'; }
			?></td>
			<td class="mag"><?php if($card['mag']) echo '+'; else echo '-'; ?></td>
			<td class="pasek"><?php if($card['a_podpis'] || $card['r_podpis']) echo '+'; else echo '-'; ?></td>
			<td class="perso"><?php if($card['isperso']) echo '+'; else echo '-'; ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; 
//echo '<pre>';	print_r($job); echo  '</pre>'; ?>
	
</div>
