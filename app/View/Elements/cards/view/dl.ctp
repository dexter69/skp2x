<dl id="cardviewdl">
<?php

    $this->Ma->dtdd('Id', $card['id']);
    $this->Ma->dtdd('Nazwa karty', $card['name']);
    
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
    $this->Ma->dd($datka, $atrs);
    
    $this->Ma->dtdd('Klient',
                    $this->Html->link($customer['name'], array(
                    'controller' => 'customers', 'action' => 'view', $customer['id']
    )));
    
    $this->Ma->dtdd('Opiekun', $owner['name']);
    
    if( $order['id'] ) {
        if( $order['nr'] )
            { $dd = $this->Html->link($this->Ma->bnr2nrh($order['nr'], $creator['inic']), array('controller' => 'orders', 'action' => 'view', $order['id']), array('escape' => false)); }
        else
            { $dd = $this->Html->link('id = '.$order['id'], array('controller' => 'orders', 'action' => 'view', $order['id'])); }
    }
    $this->Ma->dtdd('Zamówienie (H)', $dd);
    
    if( $job['nr'] ) {
        $dd = $this->Html->link( $this->Ma->bnr2nrj($job['nr'], null), array('controller' => 'jobs', 'action' => 'view', $job['id']), array('escape' => false));
    } else {
        $dd = $this->Html->link($job['id'], array('controller' => 'jobs', 'action' => 'view', $job['id']));
    }
    $this->Ma->dtdd('Zlecenie (P)', $dd);
    
    $this->Ma->dtdd('Cena', $card['price']);
    
    $dd = null;
    if( $card['ilosc'] )
        { $dd = $this->Ma->tys($card['ilosc']*$card['mnoznik']); }
    $this->Ma->dtdd('Ilość', $dd);
    
    if( $card['status'] == PRIV && $order['id'] )
        { $dd = 'ZAŁĄCZONA'; }
    else
        { $dd =  $this->Ma->status_karty($card['status']); }
    $this->Ma->dtdd('Status', $dd);
    
    $this->Ma->dtdd('Stworzone', $this->Ma->mdt($card['created']));
    $this->Ma->dtdd('Zmodyfikowane', $this->Ma->mdt($card['modified']));
    ?>
</dl>

    
    
    
		
	