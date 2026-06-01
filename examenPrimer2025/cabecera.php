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

session_start(); // activa o continúa la sesión

//para cargar el las clases
$aclArray = new ACLArray();
$acceso = new Acceso();

//Aqui es donde creamos el array cargado, METER NOMBRE
if (!isset($_SESSION["COL"])) {

//coleccion 1
$coleccion1 = new coleccion("natalia","12/05/2024",10);

$libro1 = new libro("yo","tu");
$libro1->anio ="2025";
$libro1->dia="hoy";

$libro2 = new libro("el","ella");
$libro2->anio ="2025";
$libro2->dia="ayer";

$coleccion1->aniadirLibro($libro1);
$coleccion1->aniadirLibro($libro2);

//colecion 2
$coleccion2 = new Coleccion("Raul", "12/06/2025",30);

$libro3 = new libro("DIW", "Raul");
$libro3->anio="2023";
$libro3->dia="ayer";

$coleccion2->aniadirLibro($libro3);
$coleccion2->aniadirLibro($libro1);

 $colecciones = [$coleccion1,$coleccion2];

$_SESSION["COL"]=$colecciones;

}


// Recuperar siempre el array desde sesión CAMBIAR NOMBRES
$COL = $_SESSION["COL"];

