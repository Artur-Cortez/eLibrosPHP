<?php
function remove_special_characters($string) {
    return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $string));
}
?>