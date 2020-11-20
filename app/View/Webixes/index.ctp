<?php
    $this->set('title_for_layout', 'Pulpit');    
    $theOrderDetail = $this->App->trimAll($this->element('webixes/theOrderDetail'));
    $theCustomerDetail1 = $this->App->trimAll(
        $this->element('webixes/labelName', [
            'extraClass' => null,
            'label' => 'Klient',
            'name' => '#WebixCustomer_name#'
        ]));
    $theCustomerDetail2 = $this->App->trimAll(
        $this->element('webixes/labelName', [
            'extraClass' => 'customer-full-name',
            'label' => null,//'Klient',
            'name' => '#WebixAdresSiedziby_name#'
        ]));
    $theCustomerDetail3 = $this->App->trimAll(
        $this->element("webixes/customerDetail", [
            'class' => 'the-customer-detail',
            'vars' => [
                'siedziba' => [
                    'fullName' => 'WebixAdresSiedziby_name',
                    'ulica' => 'WebixAdresSiedziby_ulica',
                    'nr' => 'WebixAdresSiedziby_nr_budynku',
                    'kod' => 'WebixAdresSiedziby_kod',
                    'miasto' => 'WebixAdresSiedziby_miasto',
                    'kraj' => 'WebixAdresSiedziby_kraj',
                    'nip' => 'WebixCustomer_vatno_txt'
                ],                
                'maxUpLinks' => maxUpLinks
            ]
        ])
    );  
    //echo $this->App->print_r2($handlowcy);
?>

<script type="text/javascript" charset="utf-8">

/*
Globalny obiekt, przechowywyjący różne użyteczne dane */
var globalAppData = {
    loggedInUser: <?php echo json_encode($loggedInUser); ?>, // Info o zalogowanym użytkowniku
    customerOwners: <?php echo json_encode($handlowcy); ?>,       
    config: { // różnorakie przydatne dane
        logoutUrl: "/users/logout",
        loginUrl: "/users/login",
        customerUrl: "/customers/view/", // url do szczegółów klienta
        delCustomerUrl: "/webixCustomers/delete/", // url do usuwania klientów
        listOfCustomersUrl: "<?php echo webixCustomersURL?>", // lista klientów / główny pulpit
        // url do zasysania klientów dla celów dodania nowego zamówienia
        //customersAddOrder: "/webixCustomers/getMany.json",
        customersGetMany: "/webixCustomers/getMany.json",
        customersHowMany: 150, // ile rekordów?
        justOneCustomerData: "/webixCustomers/getOne/",
        wyglad: {
            mainPad: 15, // definujący główny padding
            buttonOnMainToolbarWidth: 50
        },
        maxUpLinks: <?php echo maxUpLinks ?>,
    },
    template: { // tu bardziej złożone tamplates        
        theOrderDetail: "<?php echo $theOrderDetail; ?>",        
        theCustomerDetail1: '<?php echo $theCustomerDetail1; ?>',
        theCustomerDetail2: '<?php echo $theCustomerDetail2; ?>',
        theCustomerDetail3: '<?php echo $theCustomerDetail3; ?>'
    } 
};
</script>