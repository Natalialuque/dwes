<?php
class Otras implements Iterator
{
    //Propiedades 
    private int $_TOTAL_IMPORTES;
    public array $propie;

    //Puntero del iterador
    private int $_posIte = 0;

    //Constructor
    public function __construct()
    {

        $this->_TOTAL_IMPORTES = 0; 
        $this->propie = [];
    }

    //Sobrecarga dinámica

    public function __set(string $nombre, mixed $value): void
    {

        $nombre = mb_strtoupper($nombre);

        $reg = "/^[i][.*/i";
        if (preg_match($nombre, $reg)) {
            if (validaReal($value, PHP_FLOAT_MIN, PHP_FLOAT_MAX, 0)) {
                $this->propie[$nombre]= strval($value);
                $this->_TOTAL_IMPORTES += strval($value);

            }
            $this->$nombre = $value;
        } else {
            $this->propie[$nombre]= strval($value);
        }
    }



    public function __get(string $nombre): mixed
    {

        $nombre = mb_strtoupper($nombre);
        if ($nombre == "TOP_IMP") {
            return $this->_TOTAL_IMPORTES;
        }
        if (isset($this->propie[$nombre]))
            return $this->propie[$nombre];
        else {
            throw new Exception("No se encuentra la propiedad");
        }
    }

    public function __isset(string $nombre): bool
    {
        $nombre = mb_strtoupper($nombre);
        if ($nombre == "TOP_IMP")
            return true;

        return isset($this->propie[$nombre]);
    }


    //iterator
    public function rewind(): void
    {
        $this->_posIte = 0;
    }

    public function valid(): bool
    {
        return ($this->_posIte < count($this->propie));
    }

    public function current(): mixed
    {
        if ($this->_posIte == 0) {
            return $this->_TOTAL_IMPORTES;
        } else {
            return current($this->propie);
        }
    }


    public function key(): mixed
    {
        if ($this->_posIte == 0) {
            return "tot_imp";
        } else {
            $clave = key($this->propie);
            $clave =  mb_strtoupper(mb_substr($clave, 1)) .
                mb_substr($clave, 2, mb_strlen($clave) - 2) .
                mb_strtoupper(mb_substr($clave, mb_strlen($clave) - 1));
            return $clave;
        }
    }

    public function next(): void
    {
        $this->_posIte++;
        if ($this->_posIte > 0)
            next($this->propie);
    }



    /**
     * Método toString()
     *
     * @return string
     */
    public function __toString()
    {
        $cadena ="";

        foreach ($this->propie as $key => $value) 
        {
            if ($key!="TOT_IMP")
            $cadena += $key . "-";
        }

        return $cadena;
    }
}
