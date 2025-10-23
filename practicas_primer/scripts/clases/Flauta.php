<?php
//Final para q no se pueda heredar a ninguna subclase
 final class Flauta extends InstrumentoViento implements IFabricable{

/**
 * Constructor privado que crea una flauta
 *
 * @param string $material Material del que esta formado la flauta
 * @param integer $edad Edad de la flauta
 */
private function __construct(string $material,int $edad)
{
    parent::__construct($edad,$material);
}

/**
 * Metodo que crea una flauta ya que el constructor es privado
 *
 * @param array $arr Array con amterial y edad
 * @return Flauta devuelve el objeto flauta
 */
static function CrearDesdeArray(array $arr) : Flauta{
    return new Flauta($arr["material"],$arr["edad"]);
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
    return new Flauta($this->_getMaterial(),0);
}

}

?>