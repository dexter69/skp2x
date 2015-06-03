<?php
if( $result['dl'] == 'long' ) {
    $result['stop_perso'] = $this->Ma->md($result['stop_perso']);
} else {
    $result['stop_perso'] = $this->Ma->mdvs($result['stop_perso']);
}
echo json_encode($result);