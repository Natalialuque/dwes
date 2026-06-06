<?php
class claseModelos extends CActiveRecord{

    //fijamos nombre 
     protected function fijarNombre(): string
    {
        return '';
    }

    //fijamos atributos 
     protected function fijarAtributos(): array
    {
        return [];
    }

    //fijamos las descripciones  
     protected function fijarDescripciones(): array
    {
        return [
            "nombre" => "Pueb-nombre"
           
        ];
    }

    //meterlas bien !!!

    protected function fijarRestricciones(): array
    {
        return [
            [
                //primero metemos los que son obligatorios
                "ATRI" => "nombre",
                "TIPO" => "REQUERIDO",
                "MENSAJE"=> "nombre obligatorio"
            ],
            [
                //nombre, cadena 25, defecto pueblo
                "ATRI" => "nombre",
                "TIPO" => "CADENA",
                "TAMANIO"=>25,
                "MENSAJE"=> "nombre debe tener 25 caracteres"
            ],
            [
                //entero, debe estar en el rango de codigos de lista TIpos Elemento 
                "ATRI" => "cod_tipo_elemento",
                "TIPO" => "ENTERO",
                "MENSAJE" => "debe ser entero"
            ],
            [
                //y ahora le pasamos la funcion  
                "ATRI" => "cod_tipo_elemento",
                "TIPO" => "FUNCION",
                "MENSAJE" => "validaTipo"
            ],
            [
                //descripcion tipo, cadena 30, valor obtenido de cod_tipo
                "ATRI" => "descripcion_tipo",
                "TIPO" => "CADENA",
                "TAMANIO"=> 30,
                "MENSAJE"=> "cadena de 30 caracteres"
            ],
            [
                //ahora le pasamos la funcion de obtenido de cod_tipo
                "ATRI" => "descripcion_tipo",
                "TIPO" => "FUNCION",
                "FUNCION" => "obtenidoCodTipo"
            ],
            [
                //Eelemento cadena de 35
                "ATRI" => "elemento",
                "TIPO" => "CADENA",
                "TAMANIO"=> 35,
                "MENSAJE"=> "cadena de 35 caracteres"
            ],
            [
                //reconocido por la unesco, entero, valor 0-1, dependiendo valor se sabe si tiene reco
                "ATRI" => "reconocido_unesco",
                "TIPO" => "ENTERO",
                "MIN" => 0,
                "MAX"=>1,
                "MENSAJE"=>"Reconocido por la unesco debe ser 0 o 1"
            ],
            [
                //fecha de reconocimiento formato fecha mediante funcion error 
                "ATRI" => "fecha_reconocimiento",
                "TIPO" => "FECHA",
                "MENSAJE" => "fecha mal introducida",
            ],
            [
                //metemos la funcion 
                "ATRI" => "fecha_reconocimiento",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaFecha"
            ]
        ];
    }

    //vamos ahora con los valores por defecto, METERLOS BIEN !!!!
     protected function afterCreate(): void
    {
       
    }

    /**
     * ahora aqui vamos con las funciones para realizar validaciones, TENER EN CUENTA QUE VALIDACIONES CORRESPONDEN 
     */
    //de cod_tipo_elemento para ver cual toca 
    function validaTipo(){ 
       
    }

    //para el tema de la descripcion
    function obtenidoCodTipo(){
         
        
    }


    //para el tema de la fecha 
    function validaFecha(){
    }
        
}



