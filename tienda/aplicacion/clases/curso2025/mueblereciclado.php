<?php

class mueblereciclado extends mueblebase{

    //nueva propiedad 
    private int $PorcentajeReciclado;

    //constructor 
    public function __construct( string $nombre,
            string $fabricante = 'FMu:',
            string $pais = 'ESPAÑA',
            int $anio = 2020,
            string $fechaIniVenta = '01/01/2020',
            string $fechaFinVenta = '31/12/2040',
            int $materialPrincipal = 1,
            float $precio = 30.0,
            int $porcentajeReciclado = 10)
        {
            parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $materialPrincipal, $precio);
            $this->setPorcentajeReciclado($porcentajeReciclado);
        }

    //get y set HACERLO CON RANGO 
    public function setPorcentajeReciclado(int $valor): bool {
        if ($valor >= 0 && $valor <= 100) {
            $this->PorcentajeReciclado = $valor;
            return true;
        }
        $this->PorcentajeReciclado = 10;
        return false;
    }

    public function getPorcentajeReciclado(): int {
        return $this->PorcentajeReciclado;
    }

    //NO SE QUE ES 
    // public function dameListaPropiedades(): array {
    //     return array_merge(parent::dameListaPropiedades(), ['PorcentajeReciclado']);
    // }

    public function __toString(): string {
        return parent::__toString() . ", porcentaje reciclado " . $this->getPorcentajeReciclado() . "%";
    }



}

?>