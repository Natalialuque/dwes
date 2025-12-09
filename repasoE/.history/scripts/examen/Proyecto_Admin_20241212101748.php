<?php


class Proyecto_Admin extends Proyecto{

    protected string $_expediente = "2024/00001";

    public function __construct($exp) {
        parent::__construct()
        if ($this->setExpediente($exp))
        
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
}