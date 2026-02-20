<?php 
class Listas {

    //metodo statico 
    public static function ListaTiposElemento( bool $soloCodigo=false,?int $cod_tipo = null){

        //array interno con los tipos de elemento 
        $tiposElementos =[
            1 => "Monumento",
            2 => "Gastronomico",
            3 => "Sitio de interes",
            4 => "Costumbre"
        ];


        //Comprobamos que haya codigo
        if($cod_tipo!==null){
             // Si no existe ese código = false 
             if (!isset($tiposElementos[$cod_tipo])) {
                 return false; 
            } else{
                return true;
            }
            // Si existe y se pide soloCodigo = devolver todo 
            if ($soloCodigo) {
                 return $tiposElementos[$cod_tipo];
             } 
           // Si NO se indica código =devolver todas las barajas 
            $resultado = []; 
            foreach ($tiposElementos as $codigo => $datos) {
                 if ($soloCodigo) { 
                    $resultado[$codigo] = $datos;
                 } 
             } 
             
             return $resultado; 
        }
    }
}