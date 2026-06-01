<?php

class Clase2 implements Iterator{




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