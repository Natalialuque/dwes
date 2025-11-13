<?php
include_once(dirname(__FILE__) . "/../librerias/validacion.php");

class Punto
{
    // CONSTANTES
  public const COLORES = [
    "red" => ["nombre" => "rojo", "rgb" => [255, 0, 0]],
    "purple" => ["nombre" => "morado", "rgb" => [128, 0, 128]],
    "orange" => ["nombre" => "naranja", "rgb" => [255, 165, 0]],
    "gray" => ["nombre" => "gris", "rgb" => [128, 128, 128]]
];


    public const GROSORES = [
        1 => "fino",
        2 => "medio",
        3 => "grueso"
    ];

    

    // PROPIEDADES
    private int $x;
    private int $y;
    private string $color;
    private int $grosor;

    public function __construct(int $x, int $y, string $color, int $grosor)
    {
        $this->setX($x) ?: throw new Exception("Valor de X invalido");
        $this->setY($y) ?: throw new Exception("Valor de Y invalido");
        $this->setColor($color) ?: throw new Exception("Valor de Color invalido");
        $this->setGrosor($grosor) ?: throw new Exception("Valor de Grosor invalido");
    }

    //Getter's & Setter's

 /**
     * Undocumented function
     *
     * @return integer
     */
    public function getX(): int {
        return $this->x;
    }


    /**
     * Undocumented function
     *
     * @return integer
     */
    public function getY(): int {
        return $this->y;
    }


    /**
     * Undocumented function
     *
     * @return string
     */    
    public function getColor(): string{
        return $this->color;
    }


    /**
     * Undocumented function
     *
     * @return integer
     */
    public function getGrosor(): int{
        return $this->grosor;
    }


    //setter's

    /**
     * Setter que valida que el valor de x este entre 0 y hasta 20000.
     *
     * @param int $valor
     * @return boolean
     */
    public function setX(int $valor): bool{
        if (!validaEntero($valor, 0, 20000, 0)) return false;
        $this->x = $valor;
        return true;
    }


    /**
     * Setter que valida que el valor de y este entre 0 y hasta 20000.
     *
     * @param int $valor
     * @return boolean
     */
    public function setY(int $valor): bool{
        if (!validaEntero($valor, 0, 20000, 0)) return false;
        $this->y = $valor;
        return true;
    }

    

    /**
     * Setter que valida que el valor exista en la constante
     *
     * @param string $valor
     * @return boolean
     */
    public function setColor(string $valor): bool{
        if (array_key_exists($valor, self::COLORES)) {
            $this->color = $valor;
            return true;
        }
        return false;
    }


    /**
     * Setter que valida que el valor este en el rango de la contante
     *
     * @param float $valor
     * @return boolean
     */
    public function setGrosor(int $valor): bool{
        if (validaRango($valor, Punto::GROSORES, 2)) {
            $this->grosor = $valor;
            return true;
        } else return false;
    }

  
}