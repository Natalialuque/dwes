<?php
define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO", "desarrollo"); //en "produccion o en desarrollo

if (MODO_TRABAJO == "produccion")
    error_reporting(0);
   else
    error_reporting(E_ALL);



spl_autoload_register(function ($clase) {
    $ruta = RUTABASE . "/aplicacion/clases/curso2025/";  //esto es la autocarga de clases
    $fichero = $ruta . "$clase.php";
    if (file_exists($fichero)) 
        {
         require_once($fichero);
        } 
        else 
        {
            throw new Exception("La clase $clase no se ha encontrado.");
        }
});

include(RUTABASE . "/aplicacion/plantilla/plantilla.php");
//include(RUTABASE . "/aplicacion/config/acceso_bd.php");
//creo todos los objetos que necesita mi aplicación

// Colores de texto disponibles
const COLORESTEXTO = ["black","blue", "white", "red"];

// Colores de fondo disponibles
const COLORESFONDO = [ "white", "red", "green", "blue","cyan"];