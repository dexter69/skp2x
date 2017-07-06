<div class="picker-container">
    <h4 class="picker-label-container">
            <span class="label label-default"><?php echo $config['label']; ?></span>
    </h4>
    <!-- ROK -->
    <div class="btn-group">    
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $config['anydate'] ? 'Rok' : $config['years'][0]; ?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <?php
            $ile = count($config['years']);
            for( $i = 0; $i<$ile; $i++ ) {
                echo '<li><a href="#">' . $config['years'][$i] . '</a></li>';
            }         
            ?>        
        </ul>
        
    </div>

    <!-- Miesiąc -->
    <div class="btn-group">    
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $config['anydate'] ? 'Miesiąc' : $this->Ma->mies_full['01']; ?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <?php         
            foreach( $this->Ma->mies_full as $month) {
                echo '<li><a href="#">' . "$month</a></li>";
            }         
            ?>        
        </ul>
    </div>

    <!-- Dzień -->
    <div class="btn-group">    
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $config['anydate'] ? 'Dzień' :'01'; ?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <?php         
            for( $i = 1; $i<=31; $i++ ) {
                //sprintf("%2c", $i)
                echo '<li><a href="#">' . sprintf("%'02d", $i) . '</a></li>';
            }        
            ?>        
        </ul>
    </div>

    <!-- Reset -->
    <?php if( !$config['anydate'] ) { ?>

    <div class="btn-group" role="group" aria-label="...">
    <button type="button" class="btn btn-warning">R</button>  
    </div>    

    <?php } ?>

</div>

