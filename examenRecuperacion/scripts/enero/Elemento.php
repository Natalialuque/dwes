<?php 

include_once(dirname(__FILE__) . "/../../librerias/validacion.php");


class Elemento implements Iterator{

    //constantes 
    const TIPOS = [
        "sin indicar" =>0,
        "monumento" =>1,
        "costumbre"=>2,
        "gastronomia"=>3,
    ];


    //propiedad dinamica 
    private int $_tipo=0;
    private array $_ele=[];

    public function __construct(int $tipo=0,...$params){

    $this->_tipo = $tipo;

    $this->_ele = [];

    $total = count($params);

    for ($i = 0; $i < $total - 1; $i += 2) {
        $nombreProp = $params[$i];
        $valorProp = $params[$i + 1];

        if (!is_string($nombreProp)) {
            continue;
        }

        //nombre:mayuscula con la letra del medio minuscula
        $nombreProp = mb_strtoupper($nombreProp);
        $letras = mb_str_split($nombreProp);
        $nombreInterno = "";

        foreach ($letras as $index => $letra) {
            $nombreInterno .= $index === count($letras) / 2 ? mb_strtolower($letra) : $letra;
        }

        $this->_ele[$nombreInterno] = $valorProp;
    }
    }
  


    /**METODOS MÁGICOS 
     * LO HACERMOS CON ELE Y CON TIPO
    */
    public function __set(string $name, mixed $value)
    {
        $name = mb_strtolower($name);

        if ($name == "tipo") {
            $this->_tipo = $value;
        }else {
            $numeroLetras = mb_strlen($name);
            $letras = mb_str_split($name);
            $name = "";
            foreach ($letras as $index => $letra) {
                $name .= $index == ($numeroLetras / 2) ? mb_strtolower($letra) : $letra;
            }

            $this->_ele[$name] = $value;
        }
    }
      
    public function __get($name)
    {
        $name = mb_strtolower($name);

        if ($name == "tipo") {
            return $this->_tipo;
         
        } else {
            $numeroLetras = mb_strlen($name);
            $letras = mb_str_split($name);
            $name = "";
            foreach ($letras as $index => $letra) {
                $name .= $index == ($numeroLetras / 2) ? mb_strtolower($letra) : $letra;
            }

            return $this->_ele[$name];
        }
     }

    public function __isset($name)
     {
         $name = mb_strtolower($name);

        if ($name == "tipo") {
            return true;
        } else {
            $numeroLetras = mb_strlen($name);
            $letras = mb_str_split($name);
            $name = "";
            foreach ($letras as $index => $letra) {
                $name .= $index == ($numeroLetras / 2) ? mb_strtolower($letra) : $letra;
            }

            return isset($this->_ele[$name]);
        }

        return false;
     }

     public function __unset($name)
     {
         $name = mb_strtolower($name);

        if ($name == "tipo" ) {
            throw new Exception("No se puede eliminar la propiedad");
        } else {
            $numeroLetras = mb_strlen($name);
            $letras = mb_str_split($name);
            $name = "";
            foreach ($letras as $index => $letra) {
                $name .= $index == ($numeroLetras / 2) ? mb_strtolower($letra) : $letra;
            }

            unset($this->_ele[$name]);
        }
     }

    /**
     * ITERATOR
     */
  
    public function current(): mixed
    {
        return current($this->_ele);
    }

    public function key(): mixed
    {
        return (key($this->_ele));
    }

    public function next(): void
    {
        next($this->_ele);
    }

    
    public function rewind(): void
    {
        $array = [];
        $array["tipo"] = $this->_tipo;
        foreach ($this->_ele as $key => $value) {
            $array[$key] = $value;
        }
         $this->_ele = $array;
        reset($this->_ele);
    }

    public function valid(): bool
    {
        return key($this->_ele) !== null;
    }



}