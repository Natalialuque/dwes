<?php

//Clase Proyecto_Admin que hereda de Proyecto
class Proyecto_Admin extends Proyecto{

    //Propiedades
    protected string $_expediente = "2024/00001";

    //Constructor
    public function __construct(string $nombre, string $empresa, string $fechaInicio = "", string $fechaFin = "",  int $tipo=10, string $exp= "2024/00001") {
        parent::__construct($nombre, $empresa, $fechaInicio, $fechaFin, $tipo);
        if ($this->setExpediente($exp)!=0){
            $this->_expediente = "2024/00001";
        }
        $this->setFechaFin(date($this->_fecha_fin, strtotime("+20 days")));
               
    }


    /**GETTERS Y SETTETS */
    public function getExpediente(){
        return $this->_expediente;
    }
    public function setExpediente($exp){

        $reg = "/[0-9]{4}\/[0-9]{5}/";
        if(!validaCadena($exp, 10, "2024/00001")){
            return -2;
        }
        if (!validaExpresion($exp, $reg, "2024/00001")) return -1;
        $this->_expediente = $exp;
        return 0;
    }


    public function __toString()
    {
        return parent::__toString() . " con expediente " . $this->getExpediente();
    }
}