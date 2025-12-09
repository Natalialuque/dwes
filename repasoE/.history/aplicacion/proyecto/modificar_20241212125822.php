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
<div id=mostrar1>
    <?php
    mostrarDatos($equipo, $colores, $mensaje);
    echo "<div id=formulario>";
    formulario($equipo, $colores,  $datos, $errores);