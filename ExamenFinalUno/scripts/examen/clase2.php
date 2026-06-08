<?php

class Clase2 implements Iterator{





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