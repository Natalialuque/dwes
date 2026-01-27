<?php

class productosControlador extends CControlador
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

 
    $productos = new Productos();

   //filtros
    $nombre    = $_POST["nombre"]    ?? "";
    $categoria = $_POST["categoria"] ?? "";
    $borrado   = $_POST["borrado"]   ?? "";

    $cond = [];
    $params = [];

    if ($nombre !== "") {
        $cond[] = "nombre LIKE :nombre";
        $params[":nombre"] = "%".$nombre."%";
    }

    if ($categoria !== "") {
        $cond[] = "cod_categoria = :categoria";
        $params[":categoria"] = $categoria;
    }

    if ($borrado !== "") {
        $cond[] = "borrado = :borrado";
        $params[":borrado"] = $borrado;
    }

    //consulta

    $filas = $productos->buscarTodos(["select"=>"*"]);
    if (!$filas) $filas = [];

    //procesa filas
     foreach ($filas as &$fila) {

            // rellenar la fila con las acciones
            $id = $fila["cod_producto"];

          $urlConsultar = Sistema::app()->generaURL([
            "productos",
            "consultar"
            ], ["id" => $id]);


            $urlModificar = Sistema::app()->generaURL([
                "productos",
                "modificar"
            ], ["id" => $id]);

            $urlBorrar = Sistema::app()->generaURL([
                "productos",
                "borrar"
            ], ["id" => $id]);

            $fila["acciones"] =
                "<a href='$urlConsultar'>Consultar </a>" .
                "<a href='$urlModificar'>Modificar </a>" .
                "<a href='$urlBorrar'>Borrar </a>";
               
                $fila["borrado"] = $fila["borrado"] ? "SÍ" : "NO";

        unset($fila["cod_producto"]);
        unset($fila["cod_categoria"]);
    }

    //cabecera
    $cabecera = [
        ["ETIQUETA" => "Categoría",       "CAMPO" => "descripcion_categoria"],
        ["ETIQUETA" => "Nombre",          "CAMPO" => "nombre"],
        ["ETIQUETA" => "Fabricante",      "CAMPO" => "fabricante"],
        ["ETIQUETA" => "Fecha alta",      "CAMPO" => "fecha_alta"],
        ["ETIQUETA" => "Unidades",        "CAMPO" => "unidades"],
        ["ETIQUETA" => "Precio base",     "CAMPO" => "precio_base"],
        ["ETIQUETA" => "IVA",             "CAMPO" => "iva"],
        ["ETIQUETA" => "Precio IVA",      "CAMPO" => "precio_iva"],
        ["ETIQUETA" => "Precio venta",    "CAMPO" => "precio_venta"],
        ["ETIQUETA" => "Foto",            "CAMPO" => "foto"],
        ["ETIQUETA" => "Borrado",         "CAMPO" => "borrado"],
        ["ETIQUETA" => "Acciones",        "CAMPO" => "acciones"],
    ];

  
    //paginacion
    $pag    = $_GET["pag"]     ?? 1;
    $regPag = $_GET["reg_pag"] ?? 5;

    $opcPaginador = [
        "URL"              => Sistema::app()->generaURL(["productos", "index"]),
        "TOTAL_REGISTROS"  => count($filas),
        "PAGINA_ACTUAL"    => $pag,
        "REGISTROS_PAGINA" => $regPag,
        "TAMANIOS_PAGINA"  => [5=>"5",10=>"10",20=>"20"],
        "MOSTRAR_TAMANIOS" => true,
        "PAGINAS_MOSTRADAS"=> 7
    ];

    $inicio = ($pag - 1) * $regPag;
    $filas = array_slice($filas, $inicio, $regPag);

    //mostrar vista
    $this->dibujaVista(
        "index",
        [
            "fil"      => $filas,
            "cab"      => $cabecera,
            "cabpag"   => $opcPaginador,
            "nombre"   => $nombre,
            "categoria"=> $categoria,
            "borrado"  => $borrado
        ],
        "Productos"
    );
}

    /* 
    *   CONSULTAR
    */
    public function accionConsultar()
    {
   
    }


    /* 
    *   NUEVO
    */
    public function accionNuevo()
    {
        
    }

    /* 
    *   MODIFICAR
     */   
  
    public function accionModificar()
    {
        //recojo el id del producto a modificar 
        $id=-1;
        if($_REQUEST["id"]){
            $id=intval($_REQUEST["id"]);
        }

        $productos = new Productos();

        Sistema::app()->BD()->crearConsulta();

        //compruebo que hay un producto con el id
        if(!$productos->buscarPorID($id)){
            Sistema ::app()->paginaError(400,"no se ha encontrado el producto");
            return;

        }

        //se ha encontrado el equipo 
   

        //se comprueba si se ha enviado el formulario

        //nombre del modelo= nombre del array por post
        $nombre = $productos->getNombre();
        if (isset($_POST[$nombre])) {
            //asigno los valores al articulo a partir de lo
            //recogido del formulario
            $productos->setValores($_POST[$nombre]);

            //compruebo si son valido los datos del articulo
            if ($productos->validar()) { //son validos los datos del articulo

                //almaceno el articulo en la base de datos
                if ($productos->guardar()) {
                     Sistema::app()->irAPagina(array(
                    "productos",
                    "verTodos"
                    ));
                    return;
                }
                else{
                    $productos -> setError("nombre","se ha producido un error al guardar los datos");
                }

        }

        //se muestra el equipo para modificarlo
        $this->dibujaVista("modificar", ["modelo" => $productos], "Modificar producto");
    }

}


    /* 
     *  BORRADO LÓGICO
    */    
    // public function accionBorrar()
    // {

     
        
    

    /* 
     *  DESCARGAR PRODUCTOS FILTRADOS
    */
   public function accionDescargarProductos()
{
    
}

}