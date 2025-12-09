<?php
class Otras implements Iterator{
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
            $this->$nombre = strval($value);
        }
        $this->$nombre = $value;
    }
    else {
        $this->$nombre = strval($value);
    }

}



public function __get(string $nombre) :mixed
    {
        if($nombre == "top_imp"){
            return $this->_TOTAL_IMPORTES;
        }
        if (isset($this->_misBonos["B".$nombre]))
             return $this->_misBonos["B".$nombre];
        else{
            throw new Exception("No se encuentra el bono");
        }
    }


    //iterator
    public function rewind(): void {
        $this->_posIte=0;
        reset($this->propie);
    }

    public function valid(): bool {
        return ($this->_posIte<1+count($this->propie));
    }
    
    public function current() :mixed {
        if ($this->_posIte==0)
            {
              return $this->_importe_total;
            } 
          else
            {
               return current($this->propie);
            }
    }

    
    public function key() :mixed {
        if ($this->_posIte==0)
            {
                return "importe";
            }
           else
            {   
                $clave=key($this->propie);
                $clave=mb_substr($clave,1);   
                return $clave;
            }
    }

    public function next(): void {
        $this->_posIte++;
        if ($this->_posIte>1)
            next($this->propie);
        
    }

}


