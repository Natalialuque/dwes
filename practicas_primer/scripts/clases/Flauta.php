<?php
//Final para q no se pueda heredar a ninguna subclase
 final class Flauta extends InstrumentoViento implements IFabricable{

/**
 * Constructor privado que crea una flauta
 *
 * @param string $material Material del que esta formado la flauta
 * @param integer $edad Edad de la flauta
 */
private function __construct(int $edad,string $material)
{
    parent::__construct($edad,$material);
}

/**
 * Metodo que crea una flauta ya que el constructor es privado
 *
 * @param array $arr Array con amterial y edad
 * @return Flauta devuelve el objeto flauta
 */
 public static function crearDesdeArray(array $datos): static //de la clase en la que esta
    {
        $edad = $datos['edad'] ?? 0;
        $material = $datos['material'] ?? 'madera';
        return new static($edad, $material);
    }

public function __toString()
{
    return parent::__toString();
}



// Implementación de IFabricable
public function metodoFabricacion(): string { 
    return "Tallado del cuerpo, perforación de orificios, ajuste de boquilla y afinación"; 
} 
public function metodoReciclado(): string {
     return "Separar boquilla, triturar cuerpo de madera, reciclar como residuo orgánico"; 
}

/**
 * Clona una flauta con sus propiedades cambiando la edad a 0
 *
 * @return Flauta nueva flauta creada
 */
function __clone()
{
    $this->_edad = 0;
    self::$_cont++;
    $this->setOrdenCreacion(self::$_cont);
}

}

?>