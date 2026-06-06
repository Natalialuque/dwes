<?php
class Listas{
    //funcion estatica con los metodos 
    public static function listaTipoElemento (bool $completo = false, ?int $cod_tipo=null){

        //array que nos pide 
        $array = [1 => "Monumento",
                  2 => "Gastronomico", 
                  3 => "Sitio de interés", 
                  4 => "Costumbre"];


        if($completo){
            return array_keys($array);//devuelve los codigos si $completo es verdadero
        }else{
            if(is_null($cod_tipo)){ //si completo es falso y codigo null devolvemos el array
                return $array;
            }else if (array_key_exists($cod_tipo,$array)){ //si completo es falso y se indica cod_tipo dentro del array saca verdadero
                return true;
            }
            return false; //si no esta dentro del array falso 
        }

    }

}