<?php
    switch($controller) {
        case 'customers': $name = 'Klienci'; break;
        case 'cards': $name = 'Karty'; break;
        case 'orders': $name = 'Handlowe'; break;
        case 'jobs': $name = 'Produkcyjne'; break;
        default:
            $name = 'Handlowe';
    }
    
echo '<li class="dropdown">';
?>

    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><?php echo $name; ?> <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
      <li><?php
            echo $this->Html->link(
                '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Lista',
                array('controller' => $controller, 'action' => 'index'),
                array('escape' => false )); ?>
      </li>
      <li><?php
            echo $this->Html->link(
                '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Dodaj',
                array('controller' => $controller, 'action' => 'add'),
                array('escape' => false )); ?>
      </li>      
    </ul>
<?php
echo '</li>';