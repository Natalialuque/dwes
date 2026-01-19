<?php 

class Libro{

    //Porpiedades --> privadas 
    private string $_nombre="";
    private string $_autor="";

    //Propiedades --> dinamicas 
    private array $_otras=[];



    /**
     * constructor 
     * mirar luego
     */
   public function __construct(string $nombre, string $autor, ...$params){
    $this->_nombre = $nombre;
    $this->_autor = $autor;

    $this->_otras = [];

    $total = count($params);

    for ($i = 0; $i < $total - 1; $i += 2) {
        $nombreProp = $params[$i];
        $valorProp = $params[$i + 1];

        if (!is_string($nombreProp)) {
            continue;
        }

        // Normalizar nombre: minúsculas + última letra mayúscula
        $nombreProp = mb_strtolower($nombreProp);
        $letras = mb_str_split($nombreProp);
        $nombreInterno = "";

        foreach ($letras as $index => $letra) {
            $nombreInterno .= $index === count($letras) - 1 ? mb_strtoupper($letra) : $letra;
        }

        $this->_otras[$nombreInterno] = $valorProp;
    }
}










    /**
     * METODOS MAGICOS , lleva el else porque se necesita lo de la primera en minuscula y la ultima en mayuscula 
     */
     public function __set(string $name, mixed $value)
    {
        $name = mb_strtolower($name);

        if ($name == "nombre") {
            $this->_nombre = $value;
        } elseif ($name == "autor") {
            $this->_autor = $value;
        } else {
            $numeroLetras = mb_strlen($name);
            $letras = mb_str_split($name);
            $name = "";
            foreach ($letras as $index => $letra) {
                $name .= $index == ($numeroLetras - 1) ? mb_strtoupper($letra) : $letra;
            }

            $this->_otras[$name] = $value;
        }
    }

    public function __get($name)
    {
        $name = mb_strtolower($name);

        if ($name == "nombre") {
            return $this->_nombre;
        } elseif ($name == "autor") {
            return $this->_autor;
        } else {
            $numeroLetras = mb_strlen($name);
            $letras = mb_str_split($name);
            $name = "";
            foreach ($letras as $index => $letra) {
                $name .= $index == ($numeroLetras - 1) ? mb_strtoupper($letra) : $letra;
            }

            return $this->_otras[$name];
        }
    }

    public function __isset($name)
    {
        $name = mb_strtolower($name);

        if ($name == "nombre") {
            return true;
        } elseif ($name == "autor") {
            return true;
        } else {
            $numeroLetras = mb_strlen($name);
            $letras = mb_str_split($name);
            $name = "";
            foreach ($letras as $index => $letra) {
                $name .= $index == ($numeroLetras - 1) ? mb_strtoupper($letra) : $letra;
            }

            return isset($this->_otras[$name]);
        }

        return false;
    }

    public function __unset($name)
    {
        $name = mb_strtolower($name);

        if ($name == "nombre" || $name == "autor") {
            throw new Exception("No se puede eliminar la propiedad");
        } else {
            $numeroLetras = mb_strlen($name);
            $letras = mb_str_split($name);
            $name = "";
            foreach ($letras as $index => $letra) {
                $name .= $index == ($numeroLetras - 1) ? mb_strtoupper($letra) : $letra;
            }

            unset($this->_otras[$name]);
        }
    }



    /**
     * ITERATOR
     */
    //Devuelve el valor actual del puntero interno del array $_otras.
    //Es decir, si el puntero está en "nombre", devuelve el nombre; si está en "anio", devuelve el valor de "anio".
    public function current(): mixed
    {
        return current($this->_otras);
    }

    ///Devuelve la clave actual del array, pero siempre en minúsculas, tal como exige el enunciado.
    public function key(): mixed
    {
        return mb_strtolower(key($this->_otras));
    }

    //Avanza el puntero interno del array $_otras al siguiente elemento.
    public function next(): void
    {
        next($this->_otras);
    }

    //Coloca “nombre” como primer elemento  
    // Coloca “autor” como último elemento  
    // Deja las propiedades dinámicas en medio  
    // No usa un array auxiliar permanente, solo uno temporal dentro del método (permitido)
    // Reorganiza $_otras para que el orden sea exactamente el que pide el ejercicio.
    // Llama a reset() para que el puntero vuelva al primer elemento.
    public function rewind(): void
    {
        $array = [];
        $array["nombre"] = $this->_nombre;
        foreach ($this->_otras as $key => $value) {
            $array[$key] = $value;
        }
        $array["autor"] = $this->_autor;
        $this->_otras = $array;
        reset($this->_otras);
    }

    //Indica si el puntero actual sigue apuntando a un elemento válido.
    public function valid(): bool
    {
        return key($this->_otras) !== null;
    }


   

}