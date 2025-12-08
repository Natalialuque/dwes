<?php


class Proyecto_Admin extends Proyecto{

    protected string $_expediente = "2024/00001";

    public function __construct($exp) {
        
    }


    public function getExpediente(){
        return $this->_expediente;
    }
    public function setExpediente($exp){

        if(!validaCadena($exp, 10, "2024/00001")){
            return -2;
        }
        if (!validaExpresion($exp))
    }
}