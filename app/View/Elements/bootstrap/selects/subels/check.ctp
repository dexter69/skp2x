<?php
// sprawdzamy czy tablica z opcjami do generacji elementu ma

if( empty($options) ) {
    echo 'err1';
} elseif( !array_key_exists('els', $options) ) {
    echo 'err2';
} elseif( !array_key_exists('default', $options) ) {
    echo 'err3';
} elseif( count($options['els']) < 2 ) {
    echo 'err4';
} elseif( $options['default'] >= count($options['els'] ) ) {
    echo 'err5';
} else {
    echo 'ok';
}