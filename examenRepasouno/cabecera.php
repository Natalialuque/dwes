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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//gestion base de datos 
mysqli_report(MYSQLI_REPORT_ERROR);

session_start(); // activa o continúa la sesión

//jjj
$aclArray = new ACLArray();
$acceso = new Acceso();

//Aqui es donde creamos el array cargado, METER NOMBRE
if (!isset($_SESSION["COL"])) {
 //  colecciones
    $coleccion1 = new Coleccion("natalia", "09/08/2025",10);

    $libro1 = new Libro("DAWS", "yo");
    $libro1->anio="2025";
    $libro1->dia="hoy";

    $libro2 = new Libro("DAWC", "otro");
    $libro2->anio="2022";
    $libro2->dia="mañana";

    $coleccion1->aniadirLibro($libro1);
    $coleccion1->aniadirLibro($libro2);

    $coleccion2 = new Coleccion("Raul", "12/06/2025",30);

    $libro3 = new Libro("DIW", "Raul");
    $libro3->anio="2023";
    $libro3->dia="ayer";

    $coleccion2->aniadirLibro($libro3);
    $coleccion2->aniadirLibro($libro1);

    $colecciones = [$coleccion1,$coleccion2];

    $_SESSION["COL"]=$colecciones;

}

// Recuperar siempre el array desde sesión CAMBIAR NOMBRES
$COL = &$_SESSION["COL"];

