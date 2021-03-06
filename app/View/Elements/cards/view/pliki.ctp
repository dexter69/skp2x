<div class="related">
<?php
    echo $this->Ma->viewheader('ZAŁĄCZONE PLIKI', array('class' => 'masymetric')); ?>
	
    <table id="plikikarty" cellpadding = "0" cellspacing = "0">
        <tr>
            <th class="id"><?php echo 'Id'; ?></th>
            <th class="filename"><?php echo 'Nazwa Pliku'; ?></th>
            <th class="rola"><?php echo 'Przeznaczenie'; ?></th>
            <th class="size"><?php echo 'Rozmiar'; ?></th>
            <th class="data"><?php echo 'Data'; ?></th>
        </tr>
    <?php foreach ($uploads as $upload): ?>
        <?php
          if( $limited ) {
            $fileOK = justify($upload['role']);
          } else {
            $fileOK = true; // wyświetlamy bez limitów
          }
        ?>
        <tr>
            <td class="id"><?php echo $fileOK ? $upload['id'] : ""; ?></td>
            <td class="filename"><?php
                if( $fileOK ) {
                    echo $this->Html->link( $upload['filename'], array('controller' => 'uploads', 'action' => 'download', $upload['id'] ) );
                } else {
                    echo $upload['filename'];
                }
            ?>
            </td>
                <td class="rola"><?php echo $upload['roletxt']; ?></td>
                <td class="size"><?php 
                    if( $upload['filesize'] < KILO ) {
                        echo $upload['filesize'] . ' B';
                    }
                    elseif ( $upload['filesize'] < MEGA ) {
                        echo $this->Ma->colon(strval(round($upload['filesize'] / KILO, 2)), 2) . ' kB'; 
                    }
                    else {
                        echo $this->Ma->colon(strval( round($upload['filesize'] / MEGA, 2) ), 2) . ' MB'; 
                    }?>
                </td>
                <td class="data"><?php echo substr($upload['created'],0,10); ?></td>
                
        </tr>
    <?php endforeach; ?>
    </table>
</div>

<?php

    /* Sprawdź, czy dana rola pliku jest OK do wyświetlenia limitowanego */
    function justify( $rola ) {
        // dozwolone typy plików w ograniczonym widoku
        return in_array($rola, [PROJ, PODPERSO, PODGLAD, ETYKIETA]); 
    }