<?php

class mueblereciclado extends mueblebase{

    //nueva propiedad 
    private int $PorcentajeReciclado;

    /**
     * Constructor de la clase
     *
     * @param string $nombre
     * @param string $fabricante
     * @param string $pais
     * @param integer $anio
     * @param string $fechaIniVenta
     * @param string $fechaFinVenta
     * @param integer $materialPrincipal
     * @param float $precio
     * @param integer $porcentajeReciclado
     */ 
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

    /**
     * Setter para PorcentajeReciclado
     * Valida que el valor esté entre 0 y 100
     * Si no es válido, se asigna el valor por defecto (10) y se devuelve false
     *
     * @param integer $valor
     * @return boolean
     */
    public function setPorcentajeReciclado(int $valor): bool {
        if ($valor >= 0 && $valor <= 100) {
            $this->PorcentajeReciclado = $valor;
            return true;
        }
        $this->PorcentajeReciclado = 10;
        return false;
    }

    /**
     * Getter para PorcentajeReciclado
     * Devuelve el valor actual de la propiedad
     * @return integer
     */
    public function getPorcentajeReciclado(): int {
        return $this->PorcentajeReciclado;
    }

  
    /**
     * Método que devuelve la lista de propiedades disponibles
     *
     * @return array
     */
     public function dameListaPropiedades(): array {
        return array_merge(parent::dameListaPropiedades(), ['PorcentajeReciclado']);
     }


     
    /**
     * Método que devuelve el valor de una propiedad específica
     * @param string $propiedad
     * @param integer $modo
     * @param mixed $res
     * @return boolean
     */
    public function damePropiedad(string $propiedad, int $modo, mixed &$res): bool {
    // Lista de propiedades válidas
    $lista = $this->dameListaPropiedades();

    // Verificar si la propiedad existe
    if (!in_array($propiedad, $lista)) {
        return false;
    }

    // Modo 1: variable-función → llamar al método getPropiedad()
    if ($modo === 1) {
        $metodo = 'get' . $propiedad;
        if (method_exists($this, $metodo)) {
            $res = $this->$metodo();
            return true;
        }
        return false;
    }

    // Modo 2: variable-variable → acceder directamente si es posible
    if ($modo === 2) {
        // Si la propiedad es privada en la clase base, no se puede acceder directamente
        // Usamos el método get en su lugar
        $metodo = 'get' . $propiedad;
        if (method_exists($this, $metodo)) {
            $res = $this->$metodo();
            return true;
        }
        return false;
    }

    return false;
}

    /**
     * Método mágico __toString
     *
     * @return string
     */
    public function __toString(): string {
        return parent::__toString() . ", porcentaje reciclado " . $this->getPorcentajeReciclado() . "%";
    }



}

?>