<?php
class Otras {
     public int $IMPORTE_PRESUPUESTADO = 100;
     public String $PROVINCIA ="";
     private int $_TOTALIMPORTES


    private int $_posIte=0;

}



//Sobrecarga dinámica
public function __set(string $nombre, mixed $value) :void
{
    if ($nombre=="importe")
          return;

    if(!intval($nombre) || !intval($value) || $value > $this->_importe_maximo){
        throw new Exception("El bono no es numerico, el valor no es numérico o superó el maximo permitido");
    }
    else{
        $this->_misBonos["B".$nombre] = $value;
        $this->_importe_total += $value;
    }

}