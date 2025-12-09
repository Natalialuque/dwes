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
    <?php
    mostrarDatos($PRO);
    echo "<div id=formulario>";
    formulario($PRO);
}

//-------------------------- Funciones adicionales

function formulario($PRO)
{

    $propiedades = $equipo->dameListaPropiedades();

    if ($errores) { //mostrar los errores
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error)
                echo "$clave => $error<br>" . PHP_EOL;
        }
        echo "</div>"  . PHP_EOL;
    }


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
