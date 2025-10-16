<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 3"=> "./index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

//controlador
include 'libreria.php';

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 3");
cuerpo();  //llamo a la vista
finCuerpo();
//rururur
// **********************************************************

//vista
function cabecera() 

{
    
}

//vista
function cuerpo()
{
    echo"<h1>RELACION 3: FUNCIONES</h1>";

    /**ejercicio 1 */
    echo "<h3>Ejercicio 1: cuentaVeces</h3>";

            $vector = [];
            $numero = 0;

            // Primera llamada
            if (cuentaVeces($vector, "posición", 7, $numero)) {
                echo "Llamada nº $numero<br>";
                echo "Vector actualizado:<br>";
                print_r($vector);
            } else {
                echo "Error en la primera llamada<br>";
            }

            echo "<br><br>";

            // Segunda llamada
            if (cuentaVeces($vector, "otra", 2, $numero)) {
                echo "Llamada nº $numero<br>";
                echo "Vector actualizado:<br>";
                print_r($vector);
            } else {
                echo "Error en la segunda llamada<br>";
            }

            echo "<br><br>";

            // Llamada con clave inválida
            if (cuentaVeces($vector, "2daw", 5, $numero)) {
                echo "Llamada nº $numero<br>";
                echo "Vector actualizado:<br>";
                print_r($vector);
            } else {
                echo "Error: clave inválida ('2daw')<br>";
            }
}