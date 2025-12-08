<?php

class Bonos implements Iterator {
    private int $_importe_maximo=100;
    private int $_importe_total=0;
    private array $_misBonos;
    private int $_posIte=0;

    public function __construct(int $importeMax = 100)
    {
        $this->_importe_maximo = $importeMax;
        $this->_importe_total = 0;
        $this->_misBonos = [];
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

    public function __get(string $nombre) :mixed
    {
        if($nombre == "importe"){
            return $this->_importe_total;
        }
        if (isset($this->_misBonos["B".$nombre]))
             return $this->_misBonos["B".$nombre];
        else{
            throw new Exception("No se encuentra el bono");
        }
    }

    public function __isset(string $nombre) :bool
    {
        if ($nombre=="importe")
            return true;

        return isset($this->_misBonos["B".$nombre]);
    }

    public function __unset(string $nombre)
    {
        if ($nombre=="importe")
              return;
        if (isset($this->_misBonos["B".$nombre]))
            unset($this->_misBonos["B".$nombre]);
    }

    //iterator
    public function rewind(): void {
        $this->_posIte=0;
        reset($this->_misBonos);
    }

    public function valid(): bool {
        return ($this->_posIte<1+count($this->_misBonos));
    }
    
    public function current() :mixed {
        if ($this->_posIte==0)
            {
              return $this->_importe_total;
            } 
          else
            {
               return current($this->_misBonos);
            }
    }

    
    public function key() :mixed {
        if ($this->_posIte==0)
            {
                return "importe";
            }
           else
            {   
                $clave=key($this->_misBonos);
                $clave=mb_substr($clave,1);   
                return $clave;
            }
    }

    public function next(): void {
        $this->_posIte++;
        if ($this->_posIte>1)
            next($this->_misBonos);
        
    }

    

}