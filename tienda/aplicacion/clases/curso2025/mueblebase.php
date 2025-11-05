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
        private string $nombre;
        private string $fabricante;
        private string $pais;
        private string $anio;
        private string $fechaIniVenta;
        private string $fechaFinVenta;
        private string $materialPrincipal;
        private float $precio;

    
    
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

    public function getFechaIniVenta(): string {
        return $this->fechaIniVenta;
    }

    public function getFechaFinVenta(): string {
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
    public function setAnio(string $anio): bool {
    $actual = (int)date('Y');
    if (validaEntero($anio, 2020, $actual, $anio)) {
        $this->anio = $anio;
        return true;
    }
    return false;    }

    //(cadena-fecha, fecha en la que se empieza a vender el mueble, no 
    //puede ser anterior al uno de enero del Anio de inicio de fabricación, por defecto 
    //‘01/01/2020’
    public function setFechaIniVenta(string $fecha): bool {
    $limite = '01/01/' . $this->anio;
    if (validaFecha($fecha, $fecha)) {
        $fechaIni = strtotime($fecha);
        $fechaMin = strtotime($limite);
        if ($fechaIni >= $fechaMin) {
            $this->fechaIniVenta = $fecha;
            return true;
        }
    }
    return false;
}

    //cadena-fecha, fecha en la que dejará de venderse, no 
    //puede ser anterior a la FechaIniVenta, por defecto 31/12/2040’
    public function setFechaFinVenta(string $fecha): bool {
    if (validaFecha($fecha, $fecha)) {
        $fechaFin = strtotime($fecha);
        $fechaIni = strtotime($this->fechaIniVenta);
        if ($fechaFin >= $fechaIni) {
            $this->fechaFinVenta = $fecha;
            return true;
        }
    }
    return false;    }

    //entero, número que representa el material de entre los materiales definidos en la 
    //constante MATERIALES_POSIBLES
    public function setMaterialPrincipal(string $materialPrincipal): bool {
    if (validaRango($materialPrincipal, self::MATERIALES_POSIBLES, 2)) {
        $this->materialPrincipal = $materialPrincipal;
        return true;
    }
    return false;    }

    //real, por defecto 30, no puede ser menor de 30
    public function setPrecio(float $precio): bool {
    if (validaReal($precio, 30.0, 999999.99, $precio)) {
        $this->precio = $precio;
        return true;
    }
    return false;    }

    
/**CONSTRUCTOR */ /*ARREGLAR*/
public function __construct(
    string $nombre,
    int|string $materialPrincipal,
    string $fabricante = "FMu:",
    string $pais = "ESPAÑA",
    int $anio = 2020,
    string $fechaIniVenta = "01/01/2020",
    string $fechaFinVenta = "31/12/2040",
    float $precio = 30
) {
    if (self::$mueblesCreados >= self::MAXIMO_MUEBLES) {
        throw new Exception("No se pueden crear más muebles, límite alcanzado");
    }

    $this->nombre = $nombre;
    $this->fabricante = $fabricante;
    $this->pais = $pais;
    $this->anio = (string) $anio;
    $this->fechaIniVenta = $fechaIniVenta;
    $this->fechaFinVenta = $fechaFinVenta;
    $this->precio = $precio;

   
    self::$mueblesCreados++;
}



/**
 * Método dameListaPropiedades  TEN EN CUENTA LAS CLASES HIJAS
 * 
 *
 * @return array
 */
public function dameListaPropiedades(): array {
    return [
        'Nombre',
        'Fabricante',
        'Pais',
        'Anio',
        'FechaIniVenta',
        'FechaFinVenta',
        'MaterialPrincipal',
        'Precio'
    ];
}

/**
 * Método damePropiedad 
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
 * Método de clase puedeCrear
 */

public static function puedeCrear(int &$numero): bool {
    $numero = self::MAXIMO_MUEBLES - self::$mueblesCreados;
    return $numero > 0;
}

/**
 * 
 */
public function __toString(): string {
    return "MUEBLE de clase " . get_class($this) .
           " con nombre " . $this->getNombre() .
           ", fabricante " . $this->getFabricante() .
           ", fabricado en " . $this->getPais() .
           " a partir del año " . $this->getAnio() .
           ", vendido desde " . $this->getFechaIniVenta() .
           " hasta " . $this->getFechaFinVenta() .
           ", precio " . $this->getPrecio() .
           " de material " . $this->getMaterialDescripcion();
}

}
?>