<?php

class SerieFibonacci implements Iterator{


//variables 
private int $_limite;
private int $_claveActual =0;

//Constructor
public function __construct(int $limite){
        $this->_limite = $limite;
        $this->_claveActual ;
}

// Método estático con generador
public static function fFibonacci(int $ultimo): Generator{
        //YIELD permite producir valores uno a uno sin construir una lista entera de memoria
        $a = 0;
        $b = 1;
        yield $a; // F(0)
        yield $b; // F(1)

        for ($i = 2; $i <= $ultimo; $i++) {
            $siguiente = $a + $b;
            yield $siguiente;
            $a = $b;
            $b = $siguiente;
        }
}

// Métodos de Iterator
    //Devuelve el valor actual del elemento	
    public function current(): int{
        switch ($this->_claveActual) {
            case 0:
                return 0;
            case 1:
                return 1;
            default:
                $a = 0;
                $b = 1;
                for ($i = 2; $i <= $this->_claveActual; $i++) {
                    $temp = $a + $b;
                    $a = $b;
                    $b = $temp;
                }
                return $b;
        }
    }

    //Devuelve la clave actual (índice)	
    public function key(): int{
        return $this->_claveActual;
    }

    //Avanza al siguiente elemento	
    public function next(): void{
        $this->_claveActual++;
    }

    //Reinicia el puntero al primer elemento	
    public function rewind(): void{
        $this->_claveActual = 0;
    }

    //Indica si el elemento actual es válido	
    public function valid(): bool{
        return $this->_claveActual <= $this->_limite;
    }

}



?>