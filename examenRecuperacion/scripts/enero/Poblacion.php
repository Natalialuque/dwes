<?php 
include_once(dirname(__FILE__) . "/../../librerias/validacion.php");

class Poblacion{

    //constante Epocas
    const EPOCAS=[
        ["nombre"=>"prehistoria", "hasta"=>2500000, "desde"=>5300],
        ["nombre"=>"edad antigua-media", "hasta"=>5299, "desde"=>500],
        ["nombre"=>"edad moderna", "hasta"=>499, "desde"=>0],
    ];

    //Propiedades no accesibles --> private
    private string $_nombre;
    private int $_origen=1000;
    //esta seria por defecto edad antigua-media,porque el defecto de origen es 1000
    private string $_epoca="edad antigua-media";


    //arrays
    private array $_monumentos = [];
    private array $_otros = [];



    /**
     * Constructor
     */
    public function __construct(string $nombre,int $origen=1000){
         //validar nombre
        if ($this->setNombre($nombre) != -1) {
            $this->_nombre="pueblo nuevo";
        } else $this->_nombre;

        //validar origen 
        if($this->setOrigen($origen) != -1){
            throw new Exception("El origen no esta entre los valores permitidos");
        }else $this -> _origen;

    }





    /**
    *Metodos get para todas las propiedades     
     * 
     */
    public function getNombre():string{
        return $this->_nombre;
    }

    public function getOrigen():int{
        return $this->_origen;
    }

    public function getEpoca():string{
        return $this->_epoca;
    }

    /**
     * Metodos set para Nombre y Origen
     */
    public function setNombre($nombre):bool{
        if(!validaCadena($nombre,30,"")){
            return true;
        }
        if(trim($nombre)==""){
        return true;
        }
         $this ->_nombre=$nombre;
        return -1;
    }
    

    public function setOrigen($origen):bool{
        if(!validaRango($origen,[0,2500000],1)){
            return true;
        }
        
        $this->_origen=$origen;
        return -1;
    }

    /**
     * Propiedades dinamicas
     */
    private int $_comprobar=0;
    private int $_asignar=0;
    private int $_leer=0;

    
    public function __set(string $name, mixed $value){
        $name = mb_strtolower($name);

        if ($name == "asignar") {
            $this->_nombre = $value;
        }
        $this->_comprobar+=1;
     }

      public function __get($name)
     {
        $name = mb_strtolower($name);

        if ($name == "leer") {
            return $this->_nombre;
        }
        $this->_asignar+=1;

     }

      public function __isset($name)
     {
        $name = mb_strtolower($name);

        if ($name == "nombre") {
            return true;
        }
        $this->_comprobar+=1;

     }

    //simple toString mostrando
   public function resumenPropiedadesNoAccesibles(){

        return "Comprobar:".$this->_comprobar." Asignar:".$this->_asignar." Leer:".$this->_leer;
   }


   /**
     * toString
     */
    public function __toString()
    {
             return "Nombre " . $this->_nombre .
                " con origen " . $this->_origen ." años de historia, de época".
                $this->_epoca;;
    }


    /**
     * METODOS A AÑADIR --> AÑADIR ELEMENTO Y DAME ELEMETNO 
     */
    public function añadirElemento(Elemento $ele)
    {
        if($ele ==="sin indicar"){
            return 0;
        }else if($ele ==="monumento"){
            return $this->_monumentos;
        }else{
            return $this->_otros;
        }
    }

    public function dameElementos(){
         $elementos = [];

        foreach ($this->_monumentos as $index1 => $elementos) {
            foreach($this->_otros as $index2 =>$elementos){
                 $elementos["Monumento" . ($index1 + 1) ."Otros".($index2+1)] = $elementos;
            }
           
        }
        return $elementos;
    }
}