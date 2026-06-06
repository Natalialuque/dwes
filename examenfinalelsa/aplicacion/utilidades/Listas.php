<?php
// File: aplicacion/mislibrerias/Listas.php

class Listas
{


    public static function listaTrayectos(bool $soloCodigo = false, ?int $cod_tray = null)
    {

        $trayectos = [
            1 => "Malaga-Granada",
            2 => "Malaga-Madrid",
            3 => "Sevilla-Granada",
            4 => "Madrid-Sevilla",
            5 => "Sevilla-Malaga",
        ];

        if ($soloCodigo) {
            // Si no se especifica un código, se devuelve la lista completa de codigos.
            $resultado = [];
            foreach ($trayectos as $codigo => $datos) {
                $resultado[] = $codigo;
            }
            return $resultado;
        }


        if (!$soloCodigo) {
            if ($cod_tray != null) {
                if (array_key_exists($cod_tray, $trayectos))
                    return true;
                return false;
            } else {
                // Si no se especifica un código, se devuelve la array completo.
                $resultado = [];
                foreach ($trayectos as $codigo => $datos) {
                    $resultado[$codigo] = $datos;
                }
                return $resultado;
            }
        }
    }
}
