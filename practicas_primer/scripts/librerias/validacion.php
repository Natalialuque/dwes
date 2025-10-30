<?php
function validaCadena(string &$var, int $longitud, string $defecto): bool{

    if(mb_strlen($var) <= $longitud){
        return true;
    }

    $var = $defecto;
    return false;
}




?>