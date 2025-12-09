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
    //require_once(RUTABASE . "/scripts/clases/val_filter.php");
    // include(RUTABASE . "/aplicacion/clases/RegistroTexto.php");

    //creación de la sesion despues de las cargas de archivos
    session_start();

    $PRO = [];

    $pro1 = new Proyecto("proyecto1", "empresa1", "01/01/2023", "")


    //array global con los beneficiarios
    // if(!isset($_SESSION["BENEFI"])){
        
    //     $BENEFI = [
    //         $benef1,
    //         $benef2,
    //     ];

    //     $_SESSION["BENEFI"] = $BENEFI;
    // }

    // if (!isset($_COOKIE["contador"])) {
    //     setcookie("contador", 0, time() + 60 * 60 * 24 * 365); //contamos el número de veces que el usuario inicia sesión en la página durante un año
    // }
    
    // $benefi=$_SESSION["BENEFI"];
    
    // //$lista=[];
    //$lista=$benef1->getListaBonos();
    //$impo=$benef1->getImporteBonos();

/**
 * Sesión
*/

//recoge datos de la sesion
$acceso = new Acceso();

//inicializamos el ACL
$acl = new ACLArray();







   
