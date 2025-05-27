<?php

/**
 * Konfiguracja uprawnień aplikacji */

// Lista akcji, które są wyłączone ze sprawdzania w Permission Component
$config['Permissions'] = [
    'excludedActions' => [
        'users_login',
        'users_logout',
        // tmp
        'orders_index',
        // sprawdzić to jest ajax , wywoływane np. w orders index, po co
        'orders_prepaid',
        // 'cards_add'
    ],
    
    // Inne konfiguracje związane z uprawnieniami    
    'defaultRedirect' => array('controller' => 'dashboard', 'action' => 'index'),
    # ...
];

return $config;