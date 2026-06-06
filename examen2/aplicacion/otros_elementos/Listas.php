<?php

class Listas {
    public static function listaTipoElementos(?int $cod_tipo=null, bool $soloCodigo = false):array | bool {
        $array = [1=> "Monumento", 2=> "Gastronomico",3=>"Sitio de interés",4=>"Costumbre"];

        if($soloCodigo) 
            return array_keys($array);
        else {
            if(is_null($cod_tipo)) 
                return $array;
            else if(array_key_exists($cod_tipo, $array))
                return true;
            else return false;
        }
    } 
}