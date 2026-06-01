<?php
//clase libro, albergamos una serie de propiedades y de metodos, ademas tenemos constructor 

class libro implements Iterator {

    //dos propiedades privadas 
    private String $_nombre;
    private String $_autor;

    //propiedad dinamica (array)
    private array $_otras = [];

    //necesitamos un puntero para recorrer el iterator 
    private int $punte = 0;

    /**
     * Constructor
     */
    function __construct()
    {
    }

    /**
     * Implementacion de los metodos de sobrecarga
     */
      public function __set(String $name,mixed $value)
    {
    }

    public function __get(String $name)
    {
    }

    public function __isset(String $name)
    {
    }

    public function __unset(String $name)
    {
    }


    /**
     * Implementacion de los metodos de iterator
     */

    public function rewind(): void {
    }

    public function valid(): bool {
        return true;
    }

    public function current(): mixed {
        return 0;
        
    }

    public function key(): mixed {
        return 0;
        
    }

    public function next(): void {
    }

}