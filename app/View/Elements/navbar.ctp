<?php $i =0; ?>
<nav id="mojnavbar" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="collapse navbar-collapse">
            <!-- <p class="navbar-text">Klienci</p> -->
            <ul class="nav navbar-nav"><?php                
                echo $this->element('navbar-dropdown-li', array('controller' => 'customers')); 
                echo $this->element('navbar-dropdown-li', array('controller' => 'cards')); 
                echo $this->element('navbar-dropdown-li', array('controller' => 'orders'));

                // Wartość 'OX' traktukemy jako wskaźnik ograniczeń użytkownika
		        // Jeżeli może tylko swoje zamówienia wyświetlać, to nie wyświtlamy mu również linków do zlec produkcyjnych
                $limited = AuthComponent::user('OX') == IDX_OWN;
                if (!$limited) {
                    echo $this->element('navbar-dropdown-li', array('controller' => 'jobs'));
                }                 
            ?>
            </ul>
            <p class="navbar-text navbar-right logout"><?php
                echo $juzer;
                echo $this->BootHtml->glyphLink('glyphicon glyphicon-log-out', 'users', 'logout');
                ?>
            </p>
        </div>
    </div>
</nav>