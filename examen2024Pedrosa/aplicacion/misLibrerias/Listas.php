<?php 
class Listas {
    // ? para el tema de los null
    public static function listaTiposBarajas(bool $completo = false, ?int $cod_baraja = null) {

        //array interno 
       $tiposBarajas = [ 
                    5 => ["nombre" => "española normal", "min_juga" => 2, "max_juga" => 4], 
                    6 => ["nombre" => "pocker", "min_juga" => 4, "max_juga" => 4], 
                    7 => ["nombre" => "figuras", "min_juga" => 4, "max_juga" => 8] 
                ];

        // Si se indica un código concreto
         if ($cod_baraja !== null) {
             // Si no existe ese código = false 
             if (!isset($tiposBarajas[$cod_baraja])) {
                 return false; 
                } 
            // Si existe y se pide completo = devolver todo 
            if ($completo) {
                 return $tiposBarajas[$cod_baraja];
             } 
            // Si existe y NO se pide completo = solo el nombre 
            return $tiposBarajas[$cod_baraja]["nombre"];
            
            } 
            // Si NO se indica código =devolver todas las barajas 
            $resultado = []; 
            foreach ($tiposBarajas as $codigo => $datos) {
                 if ($completo) { 
                    $resultado[$codigo] = $datos;
                 } else {
                     $resultado[$codigo] = $datos["nombre"];
                 } 
             } 
             
             return $resultado; 
    }

}