<?php

echo CHTML::dibujaEtiqueta("li", [], null, false);

// Cabecera de la línea
echo "posición $posicion contenido (tipo)<br>";

// Tipos
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

    $valor = $contenido ? "true" : "false";
    $opuesto = $contenido ? "false" : "true";
    echo "booleano $valor y su opuesto $opuesto<br>";

} else {

    echo "tipo desconocido<br>";
}

echo CHTML::dibujaEtiquetaCierre("li");

echo "<hr>";

?>
