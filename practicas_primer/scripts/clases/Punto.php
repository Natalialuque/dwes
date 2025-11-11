<?php
include_once("/scripts/librerias/validacion.php");


class Punto
{
    // CONSTANTES
    public const COLORES = [
        "black" => ["nombre" => "negro", "rgb" => [0, 0, 0]],
        "yellow" => ["nombre" => "amarillo", "rgb" => [255, 255, 0]],
        "blue" => ["nombre" => "azul", "rgb" => [0, 0, 255]],
        "green" => ["nombre" => "verde", "rgb" => [0, 128, 0]]
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
        $this->setX($x) ?: throw new Exception("Valor de X no válido");
        $this->setY($y) ?: throw new Exception("Valor de Y no válido");
        $this->setColor($color) ?: throw new Exception("Valor de Color no válido");
        $this->setGrosor($grosor) ?: throw new Exception("Valor de Grosor no válido");
    }

    //Getter's & Setter's
    /**
     * Setter que valida que el valor de x este entre 0 y hasta 20000.
     *
     * @param int $valor
     * @return boolean
     */
    public function setX(int $valor): bool
    {
        if (!validaEntero($valor, 0, 20000, 0)) return false;
        $this->x = $valor;
        return true;
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * Setter que valida que el valor de y este entre 0 y hasta 20000.
     *
     * @param int $valor
     * @return boolean
     */
    public function setY(int $valor): bool
    {
        if (!validaEntero($valor, 0, 20000, 0)) return false;
        $this->y = $valor;
        return true;
    }

    public function getY(): int
    {
        return $this->y;
    }

    /**
     * Setter que valida que el valor exista en la constante
     *
     * @param string $valor
     * @return boolean
     */
    public function setColor(string $valor): bool
    {
        if (array_key_exists($valor, self::COLORES)) {
            $this->color = $valor;
            return true;
        }
        return false;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Setter que valida que el valor este en el rango de la contante
     *
     * @param float $valor
     * @return boolean
     */
    public function setGrosor(int $valor): bool
    {
        if (validaRango($valor, Punto::GROSORES, 2)) {
            $this->grosor = $valor;
            return true;
        } else return false;
    }

    public function getGrosor(): int
    {
        return $this->grosor;
    }
}