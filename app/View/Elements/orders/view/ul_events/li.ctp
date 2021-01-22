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
    <div class="postpost">
        <?php
            echo $this->element('orders/view/ul_events/the-post', ['posciki' => $posciki]);
        ?>        
    </div>
    <span class="event_no"><?php echo $licznik;?></span>    
</li>