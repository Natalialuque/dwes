<?php
//Definimos la clase enum estadoCivil
enum EstadoCivil:int{

    //casos 
    case soltero=10;
    case casado =20;
    case pareja=30;
    case viudo=40;

    //metodo descripcion que devuelve el nombre del caso concreto
    function descripcion():string{
        return $this-> name;
    }

    //Método valor que devuelve el valor del caso concreto.
    function valor():int{
        return $this-> value;
    }


    //Método estático casos que devuelve un array con todos los casos 

    static function arrayCasos():array{
        return EstadoCivil::cases();
    }
}

?>