<?php

class Libro implements Iterator{

    //propieades privadas 
    private string $_nombre="";
    private string $_autor="";

    //propiedades dinamicas 
    private array $_otras = [];

    // Puntero del iterador
    private int $_posIte = 0;
    private array $_claves = [];




    // Método para actualizar claves del iterador
    private function convertirNombre(String $name):String{
        $clave = mb_strtoupper($name);
        $ultimo = mb_strtoupper(mb_substr($name,-1));
        $clave = mb_substr($name,0,mb_strlen($name)-1).$ultimo;

        return $clave;
    }

    // __set: asigna dinámicamente propiedades
    public function __set(string $name, mixed $valor){
       
        $clave=$this->convertirNombre($name);
        //verificar
        if ($clave === 'nombrE') {
            $this -> _nombre = $valor;
            return;
        }
        
        if ($clave === 'autoR') {
            $this -> _autor = $valor;
            return;
        }
        

         $this -> _otras[$name] =$valor;

    }

    // __get: accede a propiedades dinámicas 
    public function __get(string $name){
        $clave=$this->convertirNombre($name);

        //comprobar
        if ($clave === 'nombrE') {
            return $this->_nombre;
        }

         if ($clave === 'autoR') {
            return $this->_autor;
        }
    
        if(isset($this->_otras[$name])){
            return $this->_otras[$name];
        }

        throw new Exception("La propiedad $name no existe");

    }

    // __isset: comprueba si existe la propiedad
    public function __isset(string $name): bool {
        $clave=$this->convertirNombre($name);

        return (($clave == 'nombrE') || ($clave == 'autoR') || isset($this->_otras[$name]));
       
    }

    // __unset: elimina propiedad dinámica
    public function __unset(string $name): void {
        $clave = $this->convertirNombre($name);

    if ($clave === 'nombrE') {
        unset($this->_nombre);
        return;
    }

    if ($clave === 'autorR') {
        unset($this->_autor);
        return;
    }

    if (isset($this->_otras[$name])) {
        unset($this->_otras[$name]);
    }
    }


    /**
     * IMPLEMENTENTACION DE LOS METODOS DE ITERATOR
     */
     public function rewind(): void {
        $this->_posIte = 0;
    }

    public function valid(): bool {
        return $this->_posIte < count($this->_claves);
    }

    public function current(): mixed {
        $clave = $this->_claves[$this->_posIte];
        return $clave === '_nombre' ? : $this->_otras[$clave];
    }

    public function key(): mixed {
        $clave = $this->_claves[$this->_posIte];
        if ($clave === '_nombre') return '_nombre';

        // Transformar clave: primera y última letra en mayúscula, resto minúscula
        $clave = mb_strtolower($clave);
        $len = mb_strlen($clave);
        return mb_strtoupper(mb_substr($clave, 0, 1)) .
               mb_substr($clave, 1, $len - 2) .
               mb_strtoupper(mb_substr($clave, -1));
    }

    public function next(): void {
        $this->_posIte++;
    }
}