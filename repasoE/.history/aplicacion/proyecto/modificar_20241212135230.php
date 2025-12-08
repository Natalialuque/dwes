<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
require_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");


//-------------------------- Barra de ubicación 
$ubicacion = [
    [
        "posicion" => "Inicio",
        "direccion" => "/index.php"
    ],
    ["posicion" => "Modificar",],

];

//-------------------------- Controlador



//-------------------------- Vista 
inicioCabecera("EXAMEN"); //Esto es lo que sale arriba de la pestaña de chrome
cabecera();
finCabecera();
inicioCuerpo("Modificar Proyecto", $ubicacion);
cuerpo($PRO);
finCuerpo();

function cabecera() {}

function cuerpo($PRO)
{
?>

<div id=mostrar1>
    <p>Aquí iria la página para modificar los datos pero no me ha dado tiempo</p>
    <?php
    mostrarDatos($PRO);
    echo "<div id=formulario>";
    formulario($PRO);
}

//-------------------------- Funciones adicionales

function formulario($PRO)
{



    ?>
        <!-- Formulario para realizar modificaciones -->
        <form action="" method="post">
            <?php


}


function mostrarDatos($PRO)
{

?>

    <br><br>


<?php     }
