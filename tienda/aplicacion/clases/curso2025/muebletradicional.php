<?php
class muebletradicional extends mueblebase{

     //nuevas propiedades
    private float $peso;
    private string $serie;

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
     * @param string $peso
     * @param string $serie
     */ 
    public function __construct( string $nombre,
            Caracteristicas $caracteristicas,
            int $materialPrincipal = 1,
            string $fabricante = 'FMu:',
            string $pais = 'ESPAÑA',
            int $anio = 2020,
            string $fechaIniVenta = '01/01/2020',
            string $fechaFinVenta = '31/12/2040',
            float $precio = 30.0,
            float $peso = 15,
            string $serie ="S01")
        {
            parent::__construct($nombre,$caracteristicas, $materialPrincipal,$fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);
             $this->setPeso($peso);
             $this->setSerie($serie);
        }

    /**
     * getPeso
     *
     * @return integer
     */
    public function getPeso():float{
        return $this->peso;
    }

    public function setPeso(float $valor):bool{
        if($valor>=15 && $valor<=300){
            $this->peso=$valor;
            return true;
        }
        return false;
    }

    //GETTER Y SETT DE serie 
    public function setSerie(string $serie): bool {
        $serie = trim($serie);
        if (!validaCadena($serie, 10, '')) {
            $this->serie = 'S01';
            return false;
        }
        $this->serie = $serie;
        return true;
    }

    public function getSerie(): string {
        return $this->serie;
    }

    
     public function dameListaPropiedades(): array {
         return array_merge(parent::dameListaPropiedades(), ['Peso', 'Serie']);
     }

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
 * Metodo magico __toString
 *
 * @return string
 */
    public function __toString(): string {
        return parent::__toString() . ", peso " . $this->getPeso() . "kg, serie " . $this->getSerie();
    }
}
?>