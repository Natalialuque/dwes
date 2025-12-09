<?php


class Proyecto_Admin extends Proyecto{

    protected string $_expediente = "2024/00001";

    public function __construct(string $nombre, string $empresa, string $fechaInicio = "", string $fechaFin = "",  int $tipo, string $exp) {
        parent::__construct($nombre, $empresa, $fechaInicio, $fechaFin, $tipo=10);
        if ($this->setExpediente($exp)!=0){
            $this->_expediente = "2024/00001";
        }
        $this->setFechaFin(date($this->_fecha_fin, strtotime("+20 days")));
               
    }


    public function getExpediente(){
        return $this->_expediente;
    }
    public function setExpediente($exp){

        $reg = "/[0-9]{4}[0-9]{5}/";
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