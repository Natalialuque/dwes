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

    if(mb_star)
    if(!intval($nombre) || !intval($value) || $value > $this->_importe_maximo){
        throw new Exception("El bono no es numerico, el valor no es numérico o superó el maximo permitido");
    }
    else{
        $this->_misBonos["B".$nombre] = $value;
        $this->_importe_total += $value;
    }

}




}


