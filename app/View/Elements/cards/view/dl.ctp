<dl id="cardviewdl">
<?php

    $this->Proof->dtdd('Id', $card['id']);
    $this->Proof->dtdd('Nazwa karty', $card['name']);
    
    //ustal atrybuty dka tego dd (potrzebne do perso)
    if( $card['pvis'] && $card['stop_perso']) { 
    // zalogowany użytkownik -> perso date i data perso ustawiona
        $klasa = 'termin wyroznij_date persodate';
        $title = ' title="' . $this->Ma->md($order['stop_day']) . '"';
        $data = $card['stop_perso'];
    } else {
        $klasa = 'termin wyroznij_date';
        $title = null;
        $data = $order['stop_day'];
    }
    $datka = $this->Ma->md($data);
    if( $card['pvis'] && $this->Ma->stanPersoChange( $card ) ) {
    // jeżeli można zmieniać datę perso    
        $klasa .=  ' changable';
    }
    
    echo '<dt>Termin</dt>';
    $atrs = array(
        'class' => $klasa,
        'data-id' => $card['id'],
        'data-termin' => $data
    );
    if( $title ) { $atrs['title'] = $title; } 
    $this->Proof->dd($datka, $atrs);
    
    $this->Proof->dtdd('Klient',
        $this->Html->link($customer['name'], array(
        'controller' => 'customers', 'action' => 'view', $customer['id']
    )));
    
    $this->Proof->dtdd('Opiekun', $owner['name']);
    
    if( $order['nr'] )
        { $dd = $this->Html->link($comm['handlowe'], array('controller' => 'orders', 'action' => 'view', $order['id']), array('escape' => false)); }
    else
        { $dd = $this->Html->link($comm['handlowe'], array('controller' => 'orders', 'action' => 'view', $order['id'])); }
    $this->Proof->dtdd('Zamówienie (H)', $dd);
    
    if( $job['nr'] ) {
        $dd = $this->Html->link( $this->Ma->bnr2nrj($job['nr'], null), array('controller' => 'jobs', 'action' => 'view', $job['id']), array('escape' => false));
    } else {
        $dd = $this->Html->link($job['id'], array('controller' => 'jobs', 'action' => 'view', $job['id']));
    }
    $this->Proof->dtdd('Zlecenie (P)', $dd);
    
    $this->Proof->dtdd('Cena', $comm['cena']);
    $this->Proof->dtdd('Ilość', $comm['ilosc']);
    
    if( $card['status'] == PRIV && $order['id'] )
        { $dd = 'ZAŁĄCZONA'; }
    else
        { $dd =  $this->Ma->status_karty($card['status']); }
    $this->Proof->dtdd('Status', $dd);
    
    //etykieta
    $strety = $etykieta[$card['etykieta']];
    if( $card['etykieta'] != 'niebyc' && $card['etykieta'] != 'nietyp') {
        $strety .= ' (' . $etylang[$card['etylang']] . ')';
    }    
    $this->Proof->dtdd('Etykieta', $strety);
    
    $this->Proof->dtdd('Stworzone', $this->Ma->mdt($card['created']));
    $this->Proof->dtdd('Zmodyfikowane', $this->Ma->mdt($card['modified']));
    ?>
</dl>

    
    
    
		
	