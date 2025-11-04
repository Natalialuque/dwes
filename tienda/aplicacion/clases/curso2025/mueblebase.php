<?php
require_once __DIR__ . '/../scripts/libreras/validaciones.php';

abstract class mueblebase{
   
    /**VARIABLES */

    //Constante pública MATERIALES_POSIBLES
    public const MATERIALES_POSIBLES = [
        1 => 'madera',
        2 => 'metal',
        3 => 'plástico',
        4 => 'vidrio'
    ];

    //Constante MAXIMO_MUEBLES
    const MAXIMO_MUEBLES = 10 ;

    // Variable de clase private mueblesCreados
    private static int $mueblesCreados;

    // Propiedades privadas
        public string $nombre;
        public string $fabricante;
        public string $pais;
        public string $anio;
        public DateTime $fechaIniVenta;
        public DateTime $fechaFinVenta;
        public string $materialPrincipal;
        public float $precio;

    
    
    //get y set de las propiedades 

    // Getters
    public function getMaterialDescripcion(): string {
    return self::MATERIALES_POSIBLES[(int)$this->materialPrincipal] ?? 'Desconocido';

    }
    public function getNombre(): string {
        return $this->nombre;
    }

    public function getFabricante(): string {
        return $this->fabricante;
    }

    public function getPais(): string {
        return $this->pais;
    }

    public function getAnio(): string {
        return $this->anio;
    }

    public function getFechaIniVenta(): DateTime {
        return $this->fechaIniVenta;
    }

    public function getFechaFinVenta(): DateTime {
        return $this->fechaFinVenta;
    }

    public function getMaterialPrincipal(): string {
        return $this->materialPrincipal;
    }

    public function getPrecio(): float {
        return $this->precio;
    }


    // Setters 
    //NO LLEVA METODOS POR DEFECTO 
    //cadena de máximo 40, no puede estar vacía, a mayúscula
    public function setNombre(string $nombre): bool
    {
        $nombre = strtoupper(trim($nombre));
        if (!validaCadena($nombre, 40,'')) {
            return false;
        }
        $this->nombre = $nombre;
        return true;
    }

    //cadena de máximo 30, por defecto ‘FMu:’, siempre se añade al principio FMu: si no lo tiene ya
    public function setFabricante(string $fabricante): bool {
            $fabricante = trim($fabricante);

            // Añadir prefijo si no lo tiene
            if (strpos($fabricante, 'FMu:') !== 0) {
                $fabricante = 'FMu:' . $fabricante;
            }

            // Validar longitud máxima de 30 caracteres
            if (!validaCadena($fabricante, 30, '')) {
                return false;
            }

            $this->fabricante = $fabricante;
            return true;
    }

    //(cadena, máximo 20 caracteres,    por defecto ‘ESPAÑA’),
    public function setPais(string $pais): bool
    {
        $pais = trim($pais);

        if (!validaCadena($pais, 20, '')) {
            return false;
        }

        $this->pais = $pais;
        return true;
    }

    //(entero, año de inicio de fabricación, valor entre 2020 y el año actual, por defecto 2020
    public function setAnio(string $anio): void {
        $this->anio = $anio;
    }

    //(cadena-fecha, fecha en la que se empieza a vender el mueble, no 
    //puede ser anterior al uno de enero del Anio de inicio de fabricación, por defecto 
    //‘01/01/2020’
    public function setFechaIniVenta(DateTime $fechaIniVenta): void {
        $this->fechaIniVenta = $fechaIniVenta;
    }

    //cadena-fecha, fecha en la que dejará de venderse, no 
    //puede ser anterior a la FechaIniVenta, por defecto 31/12/2040’
    public function setFechaFinVenta(DateTime $fechaFinVenta): void {
        $this->fechaFinVenta = $fechaFinVenta;
    }

    //entero, número que representa el material de entre los materiales definidos en la 
    //constante MATERIALES_POSIBLES
    public function setMaterialPrincipal(string $materialPrincipal): void {
        $this->materialPrincipal = $materialPrincipal;
    }

    //real, por defecto 30, no puede ser menor de 30
    public function setPrecio(float $precio): void {
        $this->precio = $precio;
    }
}
    


?>