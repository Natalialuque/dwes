<?php

class coleccion {

    // ============================
    //  CONSTANTES Y PROPIEDADES
    // ============================

    const TEMATICAS = [
        "cienciaficcion" => 10,
        "terror"         => 20,
        "policiaco"      => 30,
        "comedia"        => 40
    ];

    protected string $_nombre;
    protected string $_fechaAlta = "1/10/2025";
    protected int $_tematica = 10;
    protected string $_tematicaDescripcion;

    // Libros (como en tu versión)
    private array $_libros = [];

    // ⭐ NUEVO: propiedades dinámicas
    private array $_dinamicas = [];


    // ============================
    //  CONSTRUCTOR
    // ============================

    public function __construct(string $nombre, string $fechaAlta ="1/10/2025", int $tematica=10){

        // Validar nombre
        $resNombre = $this->setNombre($nombre);
        if($resNombre == -10){
            throw new Exception("error en el nombre");
        }

        // Validar fecha
        $resFecha = $this->setFechaAlta($fechaAlta);
        if($resFecha == -10){
            $this->_fechaAlta = "1/10/2025";
        }

        // Validar temática
        $resTematica = $this->setTematicas($tematica);
        if($resTematica == -10){
            $this->_tematica = 10;
        }

        // Inicializar libros
        $this->_libros = [];
    }


    // ============================
    //  GETTERS
    // ============================

    public function getNombre():string { return $this->_nombre; }
    public function getFechaAlta():string { return $this->_fechaAlta; }
    public function getTematica():int { return $this->_tematica; }
    public function getTematicaDescripcion():string { return $this->_tematicaDescripcion; }


    // ============================
    //  SETTERS
    // ============================

    public function setNombre(string $nombre):int{
        if(!validaCadena($nombre,40,"")) return -10;
        if(empty($nombre)) return -10;

        $this->_nombre = $nombre;
        return 10;
    }

    public function setFechaAlta(string $fechaAlta):int{
        if(!validaFecha($fechaAlta,"1/10/2025")) return -10;

        $fecha = new DateTime($fechaAlta);
        $hoy = new DateTime();
        $min = (new DateTime())->modify("-4 year");

        if($fecha > $hoy || $fecha < $min) return -10;

        $this->_fechaAlta = $fechaAlta;
        return 10;
    }

    public function setTematicas(int $tematica):int{
        foreach(self::TEMATICAS as $key => $value){
            if($tematica == $value){
                $this->_tematica = $value;
                $this->_tematicaDescripcion = $key;
                return 10;
            }
        }
        return -10;
    }


    // ============================
    //  ⭐ SOBRECARGA DINÁMICA
    // ============================

    public function __set(string $nombre, mixed $valor){
        // Guardamos la propiedad en el array dinámico
        $this->_dinamicas[$nombre] = $valor;
    }

    public function __get(string $nombre){
        // Si existe en dinámicas, devolverla
        if(isset($this->_dinamicas[$nombre])){
            return $this->_dinamicas[$nombre];
        }

        // Si no existe, null (o podrías lanzar excepción si prefieres)
        return null;
    }

    public function __isset(string $nombre):bool{
        return isset($this->_dinamicas[$nombre]);
    }

    public function __unset(string $nombre):void{
        unset($this->_dinamicas[$nombre]);
    }


    // ============================
    //  TO STRING
    // ============================

    public function __toString(){
        return "coleccion ".$this->_nombre.
               " añadida el ".$this->_fechaAlta.
               " de tematica ".$this->_tematicaDescripcion;
    }
}
