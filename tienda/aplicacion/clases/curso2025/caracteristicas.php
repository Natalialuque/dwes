<?php
class Caracteristicas implements Iterator {
   
    private array $Caracteristicas=[];
    private int $cont;

    function __construct(...$args){
        $this->setCaracteristicas($args);
    }

    //Como funciona: 
        /*
        * rewind(): inicia el bucle
        * valid(): comprueba si el elemento existe, si no se termina
        * key(): saca el valor en el key del foreach
        * current(): saca el valor en el value del foreach
        * next(): avanza en el bucle.
        */
        //pone el puntero al valor inicial
        public function rewind(): void{
            $this->cont=0;
        }
        //devuelve el contenido correspondiente a la posición actual
        public function current():mixed {
            return array_values($this->Caracteristicas)[$this->cont];
        }

        public function key(): mixed{
            return array_keys($this->Caracteristicas)[$this->cont];
        }
        public function next(): void{
            $this->cont++;
        }
        public function valid():bool{
            if($this->cont<=count($this->Caracteristicas)-1) return true;
            else return false;
        }

        // Set y get 
        public function getCaracteristicas():array {
            return $this->Caracteristicas;
        }

        public function setCaracteristicas(array $array):void {
            // array con las claves que debe de tener el array
            $clavesObl = ["ancho","alto","largo"];

            // si en el array que nos dan no tiene las claves ancho alto o largo se inicializan a 100
            foreach($clavesObl as $clave) {
                if(!array_key_exists($clave,$array))$array[$clave]=100;
                else if (!is_int($array[$clave])) $array[$clave]=100;
            }
            // si existe la clave ningunamas no puede tener mas aparte de las obligatorias
            if(array_key_exists("ningunamas",$array)) {
                foreach($array as $clave =>$valor) {
                    if($clave!="ancho"&&$clave!="alto"&&$clave!="largo"&&$clave!="ningunamas") unset($array[$clave]);
                }
            }

            $this->Caracteristicas=$array;
        }

    /**
     * Convierte el objeto a cadena mostrando todas las características
     *
     * @return string
     */
    public function __toString(): string {
        $salida = '';
        foreach ($this as $clave => $valor) {
            $salida .= "$clave: $valor\n";
        }
        return $salida;
    }
}

?>