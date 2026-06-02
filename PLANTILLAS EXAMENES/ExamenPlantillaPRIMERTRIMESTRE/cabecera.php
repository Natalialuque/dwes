<?php
define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO", "desarrollo"); //en "produccion o en desarrollo

if (MODO_TRABAJO == "produccion")
    error_reporting(0);
   else
    error_reporting(E_ALL);


//este metodo es para añadir 
spl_autoload_register(function ($clase) {
    $ruta = RUTABASE . "/scripts/clases/";
    $rutaExamen = RUTABASE . "/scripts/.../"; //para poder añadir lo de proyecto y demas

    $fichero = $ruta . "$clase.php";
    $ficheroExamen = $rutaExamen . "$clase.php";

    if (file_exists($fichero)) 
        {
         require_once($fichero);
        } 
    else if(file_exists($ficheroExamen)){
            require_once($ficheroExamen);
        } 
    else 
        {
            throw new Exception("La clase $clase no se ha encontrado.");
        }
});
include(RUTABASE . "/aplicacion/plantilla/plantilla.php");
require_once (RUTABASE ."/librerias/validacion.php");


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//gestion base de datos 
mysqli_report(MYSQLI_REPORT_ERROR);

session_start(); // activa o continúa la sesión

//para cargar el las clases
$aclArray = new ACLArray();
$acceso = new Acceso();

//Aqui es donde creamos el array cargado, METER NOMBRE
if (!isset($_SESSION[""])) {



}



// Recuperar siempre el array desde sesión CAMBIAR NOMBRES
$COL = &$_SESSION[""];

