<?php
class caracteristicas implements Iterator {
   
    private array $Caracteristicas=[];
    private int $cont;

    function __construct(...$args){
    if(count($args)%2!=0) unset ($args[count($args)-1]);

        $array = [];
        for($i=0;$i<count($args)-1;$i+=2) {
           $array[$args[$i]]=$args[$i+1];
        }

        $this->setCaracteristicas($array);    }

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
            $this->Caracteristicas=$array;
        }
        
//FALTA CREAR __ISSET // __UNSET // __GET 
        public function __set($name, $value){
            // para que si existe ningunamas no se pueda añadir nada mas
            $array = $this->getCaracteristicas();

            if(key_exists("ningunamas",$array) && !key_exists($name, $array)) {
                throw new Exception("No se puede añadir porque existe la propiedad ningunamas");
            }
            else $array[$name] = $value;

            $this->setCaracteristicas($array);
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