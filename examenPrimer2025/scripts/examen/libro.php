<?php
//clase libro, albergamos una serie de propiedades y de metodos, ademas tenemos constructor 

class libro implements Iterator {

    //dos propiedades privadas 
    private String $_nombre;
    private String $_autor;

    //propiedad dinamica (array)
    private array $_otras = [];


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