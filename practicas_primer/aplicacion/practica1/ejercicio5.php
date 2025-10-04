<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador

$vector = array();
$vector[1] = "esto es una cadena";
$vector["posi1"] = 25.67;
$vector[] = false;
$vector["ultima"] = array(2, 5, 96);
$vector[56] = 23;

///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 1");
cuerpo($vector);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo($vector) {

    echo "<ul>";
    foreach ($vector as $posicion => $contenido) {
        echo "posición $posicion contenido (tipo) <br>";

        if (is_array($contenido)) {
            echo "array:<br>";
            foreach ($contenido as $valorInterno) {
                echo "→ $valorInterno<br>";
            }
        } elseif (is_int($contenido)) {
            $binario = decbin($contenido);
            echo "entero bonito valor $contenido en binario $binario<br>";
        } elseif (is_float($contenido)) {
            $cuadrado = $contenido * $contenido;
            echo "real $contenido que al cuadrado es $cuadrado<br>";
        } elseif (is_string($contenido)) {
            echo "cadena -$contenido-<br>";
        } elseif (is_bool($contenido)) {
            $opuesto = $contenido ? 'false' : 'true';
            $valor = $contenido ? 'true' : 'false';
            echo "booleano $valor y su opuesto $opuesto<br>";
        } else {
            echo "tipo desconocido<br>";
        }

        echo "<hr>"; //esto separa cada iteración visualmente (opcional)
    }
    echo "</ul>";
}

?>