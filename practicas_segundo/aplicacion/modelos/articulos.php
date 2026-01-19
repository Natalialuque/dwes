<?php
class articulos extends CActiveRecord{

   protected function fijarNombre():string{
         return 'arti';
    }

    protected function fijarAtributos():array{
        return array("cod_articulo","descripcion","unidades",
                    "nombre","cod_fabricante",
                "fabricante_nombre","fecha_alta");
    }

    protected function fijarDescripciones():array{
        return array("fecha_alta"=>"Fecha de alta",
                    "cod_fabricante"=>"Fabricante",
            "nombre_fabricante"=>"Fabricante");
    }

    protected function fijarRestricciones():array{
    return array(
            array("ATRI"=>"cod_articulo,nombre",
                "TIPO"=>"REQUERIDO"),
            array("ATRI"=>"cod_articulo","TIPO"=>"ENTERO",
                "MIN"=>0),
            array("ATRI"=>"nombre","TIPO"=>"CADENA",
                "TAMANIO"=>30),
             array("ATRI"=>"unidades","TIPO"=>"ENTERO",
                "MIN"=>0,
                "MENSAJE"=>"las unidades deben ser mayores que 0",
                "DEFECTO"=>10 ),
            array("ATRI"=>"descripcion",
                "TIPO"=>"CADENA", "TAMANIO"=>60),
            array("ATRI"=>"nombre",
                "TIPO"=>"FUNCION", "FUNCION"=>"ComprobarNombre"),
            // array("ATRI"=>"cod_fabricante","TIPO"=>"ENTERO",
            //     "MIN"=>0),
            // array("ATRI"=>"fecha_alta", "TIPO"=>"FECHA"),
            // array("ATRI"=>"fecha_alta",
            // "TIPO"=>"FUNCION",
            // "FUNCION"=>"validaFechaAlta"),
        ) ;
    }

    protected function ComprobarNombre(){
        if($this->nomre="Vicente"){
            $this->setError("nombre","no puede ser vicente");
        }

    }

    protected function afterCreate():void{
        $this->cod_articulo=0;
        $this->nombre="nats";
        $this->descripcion="buenos dias";
        $this->cod_fabricante=1;
        $this->fabricante_nombre="SIN INDICAR";
    }



}