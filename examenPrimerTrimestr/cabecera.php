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
    $rutaExamen = RUTABASE . "/scripts/diciembre/"; //para poder añadir lo de proyecto y demas

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
// include(RUTABASE . "/aplicacion/config/acceso_bd.php");
/*incluir validacion*/

//gestion base de datos 
mysqli_report(MYSQLI_REPORT_ERROR);

//creo todos los objetos que necesita mi aplicación


session_start(); // activa o continúa la sesión


if (!isset($_SESSION["COL"])) {
    $COL = [];

    // $co1= new Coleccion("Coleccion1","1/10/2025",10);
    // $co2= new Coleccion("Coleccion2","1/10/2025",10);


    // Guardar en sesión
    $_SESSION["COL"] = [$co1, $co2];
}
// Recuperar siempre el array desde sesión
$COL = &$_SESSION["COL"];

//
$aclArray = new ACLArray();
$acceso = new Acceso();