<?php
//clase coleccion, albergamos una serie de propiedades y de metodos, ademas tenemos constructor 

class coleccion {

    //constante publica tematicas 
     const TEMATICAS = [
        "cienciaficcion"=>10,
        "terror"=>20,
        "policiaco"=>30,
        "comedia"=>40
    ];

    //propieades no pueden ser accedidas desde fuera, recuerda protected y poner _
    protected string $_nombre;
    protected string $_fechaAlta = "1/10/2025";
    protected int $_tematica = 10;
    protected string $_tematicaDescripcion;

    //propiedad privada para dar soporte de libros 
    private array $_libros = [];

    /**
     * Constructor 
     */
    public function __construct(string $nombre, string $fechaAlta ="1/10/2025", int $tematica=10){

        //vamos a validar estas propiedades 

        //validar nombre
        $resNombre = $this->setNombre($nombre);
        if($resNombre==-10){throw new Exception("error en el nombre");}

        //validarmos fecha 
        $resFecha = $this->setFechaAlta($fechaAlta);
        if($resFecha==-10){
            $this -> _fechaAlta="1/10/2025";
        }

        //validar tematica 
        $resTematica = $this->setTematicas($tematica);
        if($resTematica==-10){
            $this->_tematica = 10;
        }

        //!!!inicializar array libros 
        $this->_libros=[];

    }
    

    /**
     * Metodos getter's 
     **/
    public function getNombre():string{
        return $this->_nombre;
    }

    public function getFechaAlta():string{
        return $this->_fechaAlta;
    }

    public function getTematica():int{
        return $this->_tematica;
    }

    public function getTematicaDescripcion():string{
        return $this->_tematicaDescripcion;
    }

    /**
     * Metodos Setter`s
     */

    public function setNombre(string $nombre):int{
        //que no cumpla
        if(!validaCadena($nombre,40,"")){
            return -10;
        }

        //verifica que este vacio 
        if(empty($nombre)){
            return -10;
        }

        //que sea correcto
        $this -> _nombre=$nombre;
            return 10;
    }


    public function setFechaAlta(string $fechaAlta):int{

        //si no cumple con validar la fecha
        if(!validaFecha($fechaAlta,"1/10/2025")){
            return -10;
        }

        //si la fecha es mayor a hoy ni anterior a hoy menos 4 años 
        $fecha = new DateTime($fechaAlta);
        $hoy = new DateTime();
        $min = (new DateTime())->modify("-4 year");
        if($fecha>$hoy || $fecha<$min){ 
            return -10;
        }
        

        //que sea correcto 
        $this -> _fechaAlta =$fechaAlta;
            return 10;
    }


    public function setTematicas (int $tematica):int{
    // Recorremos el array de tematicas para comprobar que tiene uno de valores indices mediante un foreach
    foreach (self::TEMATICAS as $key => $value) {
            if ($tematica == $value) {
                $this->_tematica = $value;
                $this->_tematicaDescripcion = $key;
                return 10;
            }
        }

        return -10;
    }

    /**
     * No se permite sobrecargaDinamica 
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
     * Metodo toString
     */
    public function __toString(){
        return "coleccion ".$this->_nombre.
                " añadida el ".$this->_fechaAlta. 
                " de tematica ".$this->_tematicaDescripcion;
    }


    /**
     * Meto para añadir Libros 
     */
    public function aniadirLibro (libro $libro):void{
        $this->_libros[] = $libro;

    }

    /**
     * Metodo para dameLibros
     */
    public function dameLibros():array{
        $res = [];
        for($i=0;$i<count($this->_libros); $i++) {
            $res["libro".$i]=$this->_libros[$i];
        }
        return $res;
    }

}