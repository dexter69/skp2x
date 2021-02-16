<li class="post">
    <div class="postinfo">    
        <p><?php echo $imieLudzia;?></p>
        <p class="gibon">
            <span class="<?php echo $klaska;?>">
                <?php echo $whatDid;?>                
            </span>
        </p>
        <span><?php echo $datka;?></span>
    </div>
    <div class="postpost" data-evid="<?php echo $evid?>">
        <?php
            //echo $this->element('orders/view/ul_events/the-post', ['posciki' => $posciki]);
            $ret = $this->Order->constructChmurki($posciki);
            echo $ret['ol'] . $ret['msg'];
        ?>        
    </div>
    <span class="event_no"><?php echo $licznik;?></span> 
    <?php
        if( $fix ) { // jeż uż może edytować swoje zdarzenie, to wyświetl kontrolkę
            echo '<span class="fixit" ' . 'data-evid="' . $evid . '"><i class="fa fa-wrench" aria-hidden="true"></i></span>';
        }
    ?>    
    <?php echo $ret['chmurki'] ?>
</li>