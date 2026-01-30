<?php

class EquiposControlador extends CControlador
{
    public array $menuizq = [];
    public array $barraUbi = [];


   public function accionIndex()
{
    
    $this->menuizq = [
        [
            "texto" => "Inicio", 
            "enlace" => ["inicial"]
        ],
        [
            "texto" => "practica1", 
            "enlace" => ["practica1"]
        ],
        [   "texto" => "practica2", 
            "enlace" => ["practica2"]
        ],
        [   
            "texto" => "Productos",
             "enlace" => ["productos"]
        ],
    ];

    $this->barraUbi = [
        [
            "texto" => "Inicio",
            "enlace" => ["inicial"]
        ],
        [
            "texto" => "Productos",
            "enlace" => ""
        ],
    ];

    //muestra tabla de todos los equipos 
    $equi = new Productos();

    $sentWhere='';
    $sentOrder='nombre asc';
    $sentLimit = '0,3';

    //relleno clausa where a partir de los criterios de filtrado que me envian 

    //relleno clausula order a partir de los criterios de ordenacion que me envian 

    //obtengo numero de registros que cumplen condicion 

    $nilas =$equi->buscarTodosNRegistros(["where"=>$sentWhere]);

    $filaAux = $equi->buscarTodos(["where"=>$sentWhere,"order"=>$sentOrder,"limit"=>$sentLimit]);

    $filas=[];
    foreach($filaAux as $fila){
        $fila["opciones"]="modificar " .CHTML::link("modificar",Sistema::app()->generaURL(["productos","modificar"],["id"=>$fila["cod_producto"]])) ;
        
        // ."modificar " . CHTML::link()
        // ."borrar";
    }

    /*Cabeceras con los campos a mostrar*/ 
    $cabecera = [
        ["ETIQUETA" => "Nombre",          "CAMPO" => "nombre"],
        ["ETIQUETA" => "Fecha ",      "CAMPO" => "fecha_alta"],
        ["ETIQUETA" => "Fabricante",      "CAMPO" => "fabricante"],
        ["ETIQUETA" => "Unidades",        "CAMPO" => "unidades"],
    ];
 
    $this ->dibujaVista("index",["fil"=>$filas,"cab"=>$cabecera],"pagina principal");
}


 
    /* 
    *   MODIFICAR
     */   
    public function accionModificar()
    {
        
    }

}