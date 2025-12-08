<?php
class Otras {
     private int $_TOTAL_IMPORTES;
     public array $propie;
    private int $_posIte=0;

public function __construct() {
    $this->_TOTAL_IMPORTES; //Suma de todas las propiedades de tipo entero
}








//Sobrecarga dinámica
public function __set(string $nombre, mixed $value) :void
{

    $nombre = mb_strtoupper($nombre);

    $reg = "/^i[.]*/i";
    if(preg_match($nombre, $reg)){
        if(validaReal($value, PHP_FLOAT_MIN, PHP_FLOAT_MAX,0)){
            $this->$nombre = strval();
        }
    }
    else {

    }

}




}


