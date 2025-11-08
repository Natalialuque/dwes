<?php
require_once __DIR__ . '/../../../scripts/librerias/validacion.php';

abstract class mueblebase{
   
    /**VARIABLES */
     
    //Constante pública que define los materiales posibles para un mueble
    public const MATERIALES_POSIBLES = [
        1 => 'madera',
        2 => 'metal',
        3 => 'plástico',
        4 => 'vidrio'
    ];

    //// Constante que indica el número máximo de muebles que se pueden crear
    const MAXIMO_MUEBLES = 10 ;

    // Variable de clase que lleva el conteo de muebles creados
    private static int $mueblesCreados=0;

    // Propiedades privadas que definen los atributos básicos del mueble
        private string $nombre;
        private string $fabricante;
        private string $pais;
        private string $anio;
        private string $fechaIniVenta;
        private string $fechaFinVenta;
        private int $materialPrincipal;
        private float $precio;

    // Propiedad privada que almacena las características dinámicas del mueble        
    private Caracteristicas $caracteristicas;
    
    
    //MÉTODOS GETTERS 
    public function getMaterialDescripcion() {
        if(validaRango($this->materialPrincipal, MuebleBase::MATERIALES_POSIBLES, 2))
            return MuebleBase::MATERIALES_POSIBLES[$this->materialPrincipal];
        else
            return "no existe material con ese numero";
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

    //MÉTODOS SETTERS CON VALIDACIONES
    
    /**
     * cadena de máximo 40, no puede estar vacía, a mayúscula
     *
     * @param string $nombre
     * @return boolean
     */
    public function setNombre(string $nombre): bool {
    $nombre = strtoupper(trim($nombre));
    if (!validaCadena($nombre, 40, '')) {
        $this->nombre = "SIN NOMBRE";
        return false;
    }
    $this->nombre = $nombre;
    return true;
}


    /**
     * cadena de máximo 30, por defecto ‘FMu:’, 
     * siempre se añade al principio FMu: si no lo tiene ya
     *
     * @param string $fabricante
     * @return boolean
     */
    public function setFabricante(string $fabricante): bool {
    $fabricante = trim($fabricante);
    if (str_starts_with($fabricante, 'FMu:') !== 0) {
        $fabricante = 'FMu:' . $fabricante;
    }

    if (!validaCadena($fabricante, 30, '')) {
        $this->fabricante = "FMu:";
        return false;
    }

    $this->fabricante = $fabricante;
    return true;
}

    /**
     * (cadena, máximo 20 caracteres,    por defecto ‘ESPAÑA’),
     *
     * @param string $pais
     * @return boolean
     */
   public function setPais(string $pais): bool {
    $pais = trim($pais);
    if (!validaCadena($pais, 20, '')) {
        $this->pais = "ESPAÑA";
        return false;
    }

    $this->pais = $pais;
    return true;
}


    /**
     *  (entero, año de inicio de fabricación, valor entre 2020 y el
     *  año actual, por defecto 2020
     *
     * @param string $anio
     * @return boolean
     */
    public function setAnio(string $anio): bool {
    $actual = (int)date('Y');
    if (validaEntero($anio, 2020, $actual, $anio)) {
        $this->anio = $anio;
        return true;
    }

    $this->anio = 2020;
    return false;
}


    
    /**
     * Establece la fecha de inicio de venta,
     *  no puede ser anterior al 1 de enero del año de fabricación
     *
     * @param string $fecha
     * @return boolean
     */
   public function setFechaIniVenta(string $fechaIniVenta): bool {
    if (!isset($this->anio)) {
        $this->fechaIniVenta = "01/01/2020"; // valor seguro
        return false;
    }

    if (validaFecha($fechaIniVenta, "01/01/2020")) {
        $dateFecha = DateTime::createFromFormat('d/m/Y', $fechaIniVenta);
        $dateFechaLimite = DateTime::createFromFormat('d/m/Y', '01/01/' . $this->anio);

        if ($dateFecha && $dateFechaLimite && $dateFecha >= $dateFechaLimite) {
            $this->fechaIniVenta = $fechaIniVenta;
            return true;
        }
    }

    $this->fechaIniVenta = "01/01/" . $this->anio;
    return false;
}


    /**
     * cadena-fecha, fecha en la que dejará de venderse, no 
    *puede ser anterior a la FechaIniVenta, por defecto 31/12/2040’
     *
     * @param string $fecha
     * @return boolean
     */
   public function setFechaFinVenta(string $fechaFinVenta): bool {
    if (!isset($this->fechaIniVenta)) {
        $this->fechaFinVenta = "31/12/2040"; // valor seguro
        return false;
    }

    if (validaFecha($fechaFinVenta, "31/12/2040")) {
        $dateFecha = DateTime::createFromFormat('d/m/Y', $fechaFinVenta);
        $dateFechaLimite = DateTime::createFromFormat('d/m/Y', $this->fechaIniVenta);

        if ($dateFecha && $dateFechaLimite && $dateFecha >= $dateFechaLimite) {
            $this->fechaFinVenta = $fechaFinVenta;
            return true;
        }
    }

    $this->fechaFinVenta = "31/12/2040";
    return false;
}


    /**
     * Establece el material principal, 
     * debe estar en la lista de materiales posibles
     *
     * @param string $materialPrincipal
     * @return boolean
     */
  public function setMaterialPrincipal(string $materialPrincipal): bool {
    if (validaRango($materialPrincipal, self::MATERIALES_POSIBLES, 2)) {
        $this->materialPrincipal = (int)$materialPrincipal;
        return true;
    }

    $this->materialPrincipal = 1; // valor por defecto
    return false;
}



    /**
     * real, por defecto 30, no puede ser menor de 30
     *
     * @param float $precio
     * @return boolean
     */
    public function setPrecio(float $precio): bool {
    if (validaReal($precio, 30.0, 999999.99, $precio)) {
        $this->precio = $precio;
        return true;
    }

    $this->precio = 30.0; // Valor por defecto
    return false;
}


    
   /**
    * CONSTRUCTOR
    *
    * @param string $nombre
    * @param string $fabricante
    * @param string $pais
    * @param integer $anio
    * @param string $fechaIniVenta
    * @param string $fechaFinVenta
    * @param integer|string $materialPrincipal
    * @param integer $precio
    */
    public function __construct(
        string $nombre,
        Caracteristicas $caracteristicas,
        int $materialPrincipal,
        string $fabricante = "FMu",
        string $pais = "ESPAÑA",
        int $anio = 2020,
        string $fechaIniVenta = "01/01/2020",
        string $fechaFinVenta = "31/12/2040",
        float $precio = 30
    ) {
        if (self::$mueblesCreados >= self::MAXIMO_MUEBLES) {
            throw new Exception("Se ha alcanzado el máximo de muebles permitidos.");
        }

        if (!$this->setNombre($nombre)) {
            throw new Exception("Nombre inválido.");
        }

        $this->setFabricante($fabricante);
        $this->setPais($pais);
        $this->setAnio($anio);
        $this->setFechaIniVenta($fechaIniVenta);
        $this->setFechaFinVenta($fechaFinVenta);
        if(!$this->setMaterialPrincipal($materialPrincipal))$this->setMaterialPrincipal(0);
        $this->setPrecio($precio);
        $this->caracteristicas=$caracteristicas;

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
        'nombre',
        'fabricante',
        'pais',
        'anio',
        'fechaIniVenta',
        'fechaFinVenta',
        'materialPrincipal',
        'precio'
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
 *   Método estático que indica si se pueden crear más muebles
 *
 * @param integer $numero
 * @return boolean
 */
public static function puedeCrear(int &$numero): bool {
    $numero = self::MAXIMO_MUEBLES - self::$mueblesCreados;
    return $numero > 0;
}


/**
 * Metodo añadir
 *
 * @param [type] ...$args
 * @return void
 */
public function anadir(...$args): void {
    $total = count($args);

    // Si hay un número impar de argumentos, ignoramos el último
    if ($total % 2 !== 0) {
        $total--;
    }

    $array = [];
    for ($i = 0; $i < $total; $i += 2) {
        $clave = $args[$i];
        $valor = $args[$i + 1];
        $array[$clave] = $valor;
    }

    // Ahora sí, pasamos el array completo
    $this->caracteristicas->setCaracteristicas($array);
}



   /**
    * Exportar caracteristicas
    *
    * @return string
    */
  public function exportarCaracteristicas(): string {
    if (!isset($this->caracteristicas)) {
        return "Sin características definidas.";
    }

    $salida = '';
    foreach ($this->caracteristicas as $clave => $valor) {
        $salida .= "$clave: $valor\n";
    }

    return $salida;
}

    /**
     * Metodo toString
     *
     * @return string
     */
    public function __toString(): string {
      return "MUEBLE de clase " . get_class($this) .
           " con nombre " . $this->getNombre() .
           ",<br> fabricante " . $this->getFabricante() .
           ", fabricado en " . $this->getPais() .
           " a partir del año " . $this->getAnio() .
           ", <br>vendido desde " . $this->getFechaIniVenta() .
           " hasta " . $this->getFechaFinVenta() .
           ", precio " . $this->getPrecio() .
           " € de material " . $this->getMaterialDescripcion() .
           "<br>con caracteristicas " . $this->exportarCaracteristicas();
}


}
?>