<?php 

include_once(dirname(__FILE__) . "/../../librerias/validacion.php");

class Coleccion {

    //constante public 
    const TEMATICAS = [
        10 => " cienciaficcion",
        20 => "terror",
        30 => "policiaco",
        40 => "comedia",
    ];
    
    //propiedades 
    protected string $_nombre;
    protected string $_fecha_alta="1/10/2025";
    protected int $_tematica=10;
    
    
    //este es calculado
    protected string $_tematica_descripcion;

    //AÑADIR LIBROS
    private Libro $_libro;



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
            $this->_fecha_alta = "01/10/2025";
        }

        // VALIDAR TEMATICA
        $resTematica=$this->setTematica($tematica);
        if($resTematica==-10) $this->_tematica=10;
    }


    /**
     * Metodos GET
     *
     * @return void
     */ 
    public function getNombre(){
        return $this->_nombre;
    }

    public function getFechaAlta(){
        return $this->_fecha_alta;
    }

    public function getTematica(){
        return $this->_tematica;
    }

    public function getTematicaDescripcion(){
        return $this->_tematica_descripcion;
    }

    /**
     * Metodos SET
     *
     * @param [type] $nombre
     * @return integer
     */
    public function setNombre($nombre): int{
       if(!validaCadena($nombre,40,"")){
        return -10;
    }
     if(trim($nombre)==""){
        return -10;
    }
    $this ->_nombre=$nombre;
    return 10;
    }



    public function setfecha($fecha):int{

         if (!validaFecha($fecha, date('d/m/y',strtotime("-4 year")),"1/10/2025")) {
            return -10;
        }
        $this -> _fecha_alta=$fecha;
        return 10;
    }

    public function setTematica($tematica):int{
          if (!validaEntero($tematica, 10, 40, 10)){
            return -10;
        }
        $this -> _tematica=$tematica;
        return 10;
    }

    /**
     * No sobreCarga dinamica
     *
     * @param string $nombre
     * @param mixed $value
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
     * ToString
     *
     * @return string
     */
    public function __toString()
        {
             return "Coleccion " . $this->_nombre .
                " añadida el " . $this->_fecha_alta .
                " de tematica " . $this->_tematica_descripcion;
    }


   /**
    * 
    *
    * @param string $nombre
    * @param mixed $valor
    * @param integer $n_prop
    * @param [type] ...$valoresPropiedades
    * @return boolean
    */
    public function aniadelirbo(): bool
    {

       return true;
    }


    /**
     * Metodo para mostrar los libros  $$$
     */
    public function dameLibros():array{
        $lista = [];

        foreach ($this->_libro as $key => $value) 
        {
            if ($key!="nombre")
                $lista[$key] = $value;
        }

        return $lista;
    }

}