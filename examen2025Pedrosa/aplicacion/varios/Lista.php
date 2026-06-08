<?php
class Lista
{
    public static function listaTrayectos(bool $completo = false, ?int $cod_trayecto = null): array|string|false
    {
        $trayectos = [
            3 => ["nombre" => "urbano corto", "num_paradas" => 5, "precio" => 1.50],
            5 => ["nombre" => "urbano largo", "num_paradas" => 10, "precio" => 2.00],
            8 => ["nombre" => "interurbano", "num_paradas" => 15, "precio" => 3.50],
        ];

        if ($cod_trayecto !== null) {
            if (!array_key_exists($cod_trayecto, $trayectos)) {
                return false;
            }

            return $completo ? $trayectos[$cod_trayecto] : $trayectos[$cod_trayecto]["nombre"];
        }

        if ($completo) {
            return $trayectos;
        }

        $nombres = [];
        foreach ($trayectos as $codigo => $datos) {
            $nombres[$codigo] = $datos["nombre"];
        }

        return $nombres;
    }
}
