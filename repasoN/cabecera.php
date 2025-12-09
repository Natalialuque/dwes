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
// include(RUTABASE . "/aplicacion/config/acceso_bd.php");
/*incluir validacion*/

//gestion base de datos 
mysqli_report(MYSQLI_REPORT_ERROR);


session_start(); // activa o continúa la sesión

// Apartado 4: creación inicial de proyectos
if (!isset($_SESSION["PRO"])) {
    $PRO = [];

    // Proyecto normal
    $pro1 = new Proyecto("Proyecto1", "Empresa1", "01/01/2023", "02/02/2023", 10);
    $nprop = 0;
    $pro1->aniadeOtras("provincia", "Málaga", $nprop,
                       "importe_presupuestado", 5000,
                       "cliente", "Ayuntamiento");

    // Proyecto de administración
    $pro2 = new Proyecto_Admin("ProyectoAdmin1", "EmpresaAdmin1", "01/02/2020", "02/02/2024", 20, "1111/11111");
    $nprop = 0;
    $pro2->aniadeOtras("provincia", "Sevilla", $nprop,
                       "importe_presupuestado", 8000,
                       "cliente", "Junta");

    // Guardar en sesión
    $_SESSION["PRO"] = [$pro1, $pro2];
}

// Recuperar siempre el array desde sesión
$PRO = &$_SESSION["PRO"];


//
$aclArray = new ACLArray();
$acceso = new Acceso();