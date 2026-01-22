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
    $rutaExamen = RUTABASE . "/scripts/enero/"; //para poder añadir lo de proyecto y demas

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


//Aqui es donde creamos el array cargado, METER NOMBRE
if (!isset($_SESSION["POB"])) {
//  poblaciones
    $poblacion1 = new Poblacion("azul",2500);

    $elemento1 = new Elemento(0,"yop","espectacular");

    $elemento2 = new Elemento(2,"tup","fantastico");   

    $poblacion1->añadirElemento($elemento1);
   $poblacion1->añadirElemento($elemento2);

    $poblacion2 = new Poblacion("verde",78978);

    $elemento3 = new Elemento(1,"el","hermoso");

    $poblacion2->añadirElemento($elemento3);


    $poblacion = [$poblacion1,$poblacion2];

    $_SESSION["POB"]=$poblacion;

}


// Recuperar siempre el array desde sesión CAMBIAR NOMBRES
$POB = &$_SESSION["POB"];

//
$aclArray = new ACLArray();
$acceso = new Acceso();