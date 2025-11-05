<?php
class muebletradicional extends mueblebase{

    //nueva propiedad 
    private int $peso;
    private string $serie;

    //constructor 
    public function __construct( string $nombre,
            string $fabricante = 'FMu:',
            string $pais = 'ESPAÑA',
            int $anio = 2020,
            string $fechaIniVenta = '01/01/2020',
            string $fechaFinVenta = '31/12/2040',
            int $materialPrincipal = 1,
            float $precio = 30.0,
            int $peso = '15',
            string $serie ="S01")
        {
            parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $materialPrincipal, $precio);
             $this->setPeso($peso);
             $this->setSerie($serie);
        }

    //GETTER Y SETTERS DE peso 
    public function getPeso():int{
        return $this->peso;
    }

    public function setPeso(int $valor):bool{
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

    //NO SE QUE ES 
    // public function dameListaPropiedades(): array {
    //     return array_merge(parent::dameListaPropiedades(), ['Peso', 'Serie']);
    // }

    public function __toString(): string {
        return parent::__toString() . ", peso " . $this->getPeso() . "kg, serie " . $this->getSerie();
    }
}
?>