<?php

function getAtt($atributo, $arr) {
    return array_key_exists($atributo, $arr) ? $arr[$atributo] : null;
};
    
?>