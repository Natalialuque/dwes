<?php

    define("RUTABASE", dirname(__FILE__));
    //define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
    define("MODO_TRABAJO", "desarrollo"); //en "produccion o en desarrollo
    
    if (MODO_TRABAJO == "produccion")
            error_reporting(0);
        else
            error_reporting(E_ALL);

    spl_autoload_register(function ($clase) {
        $ruta = RUTABASE . "/scripts/clases/";
        $rutaExamen = RUTABASE . "/scripts/examen/";

        $fichero = $ruta . "$clase.php";
        $ficheroExamen = $rutaExamen . "$clase.php";

        if (file_exists($fichero)) {
            require_once($fichero);//carga la ruta de los cicheros de clase
        } else if(file_exists($ficheroExamen)){
            require_once($ficheroExamen);//carga la ruta de los ficheros del examen
        }else {
            throw new Exception("La clase $clase no se ha encontrado.");
        }
    });
    
    require_once(RUTABASE . "/aplicacion/plantilla/plantilla.php");


    //creación de la sesion despues de las cargas de archivos
    session_start();

    $PRO = [];

    $pro1 = new Proyecto("proyecto1", "empresa1", "01/01/2023", "02/02/2023", 10);
    $pro2 = new Proyecto_Admin("proyectoAdmin1", "empresaAdmin1", "01/02/2020", "02/022024", 20, "1111/11111");

$pro1->aniadeOtras("adicional1", "valor1", )

    //array global con los proyectos
    if(!isset($_SESSION["PRO"])){
        
        $PRO = [
            $pro1,
            $pro2,
        ];

        $_SESSION["PRO"] = $PRO;
    }

    if (!isset($_COOKIE["contador"])) {
        setcookie("contador", 0, time() + 60 * 60 * 24 * 365); //contamos el número de veces que el usuario inicia sesión en la página durante un año
    }
    
    $PRO=$_SESSION["PRO"];
    

/**
 * Sesión
*/

//recoge datos de la sesion
$acceso = new Acceso();

//inicializamos el ACL
$acl = new ACLArray();







   
