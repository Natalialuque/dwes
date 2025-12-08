<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
require_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");


//-------------------------- Barra de ubicación 
$ubicacion = [
    [
        "posicion" => "Tienda",
        "direccion" => "/index.php"
    ],
    ["posicion" => "Modificar",],

];

//-------------------------- Controlador



//-------------------------- Vista 
inicioCabecera("Tienda"); //Esto es lo que sale arriba de la pestaña de chrome
cabecera();
finCabecera();
inicioCuerpo("Modificar Equipo", $ubicacion);
cuerpo($equipo, $colores, $datos, $errores, $mensaje);
finCuerpo();

function cabecera() {}

function cuerpo($equipo, $colores, $datos, $errores, $mensaje)
{
?>

<div id=mostrar1>
    <?php
    mostrarDatos($equipo, $colores, $mensaje);
    echo "<div id=formulario>";
    formulario($equipo, $colores,  $datos, $errores);