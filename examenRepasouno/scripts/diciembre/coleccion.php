<?php
include_once(dirname(__FILE__) . "/../../librerias/validacion.php");

class Coleccion{

    //Tematicas--> constante publica 
    public const TEMATICAS = [
        "cienciaficcion" => 10,
        "terror" => 20,
        "policiaco" => 30,
        "comedia" => 40
    ];


    //Propiedades --> acuerdate de _
    protected string $_nombre;
    protected string $_fecha_alta ="1/10/2025";
    protected int $_tematica = 10;

        //propiedades calculadas 
        protected string $_tematica_descripcion;

    //ARRAY     
    private array $_libros = [];

    
    /**
     * Constructor
     *
     * @param string $nombre
     * @param string $fechaAlta
     * @param integer $tematica
     */
    public function __construct(string $nombre,string $fechaAlta="1/10/2025", int $tematica=10){
         // VALIDAR NOMBRE
        $resNombre=$this->setNombre($nombre);
        if($resNombre==-10) throw new Exception("Fallo en el nombre");

        // VALIDAR FECHA
        if ($this->setFechaAlta($fechaAlta) == -10) {
            $this->_fecha_alta = "1/10/2025";
        }

        // VALIDAR TEMATICA
        if ($this->setTematica($tematica) == -10) {
            $this->_tematica = array_values(self::TEMATICAS)[0];
            $this->_tematica_descripcion = array_keys(self::TEMATICAS)[0];
        }

    }

    /**
     * Metodos Get
     */
     public function getNombre():string{
        return $this->_nombre;
    }

    public function getFechaAlta():string{
        return $this->_fecha_alta;
    }

    public function getTematica():int{
        return $this->_tematica;
    }

    public function getTematicaDescripcion():string{
        return $this->_tematica_descripcion;
    }

   
    /**
     * Metodos Set
     */
    public function setNombre($nombre):int{
        if(!validaCadena($nombre,40,"")){
            return -10;
        }
        if(trim($nombre)==""){
        return -10;
        }
         $this ->_nombre=$nombre;
        return 10;
    }
    
    public function setFechaAlta($fecha): int{
        // Validación básica de formato (si tu validaFecha hace eso)
        if (!validaFecha($fecha,"1/10/2025")) {
            return -10;
        }

        $date = DateTime::createFromFormat("d/m/Y", $fecha);
        if (!$date) {
            return -10;
        }

        $hoy = new DateTime();
        $min = (new DateTime())->modify("-4 years");

        if ($date > $hoy || $date < $min) {
            return -10;
        }

        $this->_fecha_alta = $date->format("d/m/Y");
        return 10;
    }

   public function setTematica($tematica): int{
    // Comprobar que el valor está dentro de los valores permitidos
    foreach (self::TEMATICAS as $key => $value) {
            if ($tematica == $value) {
                $this->_tematica = $value;
                $this->_tematica_descripcion = $key;
                return 10;
            }
        }

        return -10;
    }


    /**
     *No permitir sobrecarga Dinamica 
     */
    public function __set(string $nombre, mixed $value)
    {
        throw new Exception("No permite la coleccion" . $nombre);
    }

    public function __get(string $nombre)
    {
        throw new Exception("No permite la coleccion" . $nombre);
    }

    public function __isset(string $nombre)
    {
        return false;
    }

    /**
     * toString
     */
    public function __toString()
    {
             return "Coleccion " . $this->_nombre .
                " añadida el " . $this->_fecha_alta .
                " de tematica " . $this->_tematica_descripcion;
    }

    /**
     * FUNCIONES DE AÑADIR LIBRO Y DAMELIBROS
     */
     public function aniadirLibro(Libro $libro)
    {
        $this->_libros[] = $libro;
    }

    public function dameLibros(): array
    {
        $libros = [];

        foreach ($this->_libros as $index => $libro) {
            $libros["libro" . ($index + 1)] = $libro;
        }

        return $libros;
    }



}