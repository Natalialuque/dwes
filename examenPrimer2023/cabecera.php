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
    $rutaExamen = RUTABASE . "/scripts/examen/"; //para poder añadir lo de proyecto y demas

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

// Guardamos las sesiones dentro del proyecto para evitar problemas de permisos con C:\xampp\tmp.
$rutaSesiones = RUTABASE . "/sesiones";
if (!is_dir($rutaSesiones)) {
    mkdir($rutaSesiones, 0777, true);
}
session_save_path($rutaSesiones);
session_start(); // activa o continúa la sesión

//para cargar el las clases
$aclArray = new ACLArray();
$acceso = new Acceso();

//Aqui es donde creamos el array cargado,
//solo se inicializa si todavia no existe en la sesion.
if (!isset($_SESSION["BENEFI"])) {
    $_SESSION["BENEFI"] = [];

    try {
        // Primer beneficiario inicial con dos bonos.
        $ben = new Beneficiario("Ana Lopez", "12345678Z", 1, "12/05/1990");
        $anadidos = 0;
        $ben->aniadeBonos($anadidos, "101", "25", "102", "30");
        $_SESSION["BENEFI"][] = $ben;

        // Segundo beneficiario inicial con dos bonos.
        $ben = new Beneficiario("Luis Perez", "X1234567L", 2, "03/11/2010");
        $anadidos = 0;
        $ben->aniadeBonos($anadidos, "201", "15", "202", "20");
        $_SESSION["BENEFI"][] = $ben;
    } catch (Exception $e) {
        // Si fallase algun dato inicial, dejamos el array vacio para no romper la pagina.
        $_SESSION["BENEFI"] = [];
    }

}



// Recuperar siempre el array desde sesión
$BENEFI = $_SESSION["BENEFI"];

