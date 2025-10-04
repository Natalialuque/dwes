<<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador
$vector = array(
    "primera" => 12.56,
    24 => true,
    67 => 23.76
);

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

  echo "Simulación de foreach usando funciones de recorrido:\n\n";

echo "<ul>";
//Usando current, key, next, reset
reset($vector); // Asegura que el puntero esté al inicio
while (key($vector) !== null) {
    $indice = key($vector);
    $valor = current($vector);
    echo "Índice: $indice → Valor: ";
    echo is_bool($valor) ? ($valor ? 'true' : 'false') : $valor;
    echo "<br>";
    next($vector);
}
echo "</ul>";


echo "\nSimulación de foreach usando array_keys y array_values:\n\n";

// Usando array_keys y array_values
$claves = array_keys($vector);
$valores = array_values($vector);

echo "<ul>";
for ($i = 0; $i < count($claves); $i++) {
    $indice = $claves[$i];
    $valor = $valores[$i];
    echo "Índice: $indice → Valor: ";
    echo is_bool($valor) ? ($valor ? 'true' : 'false') : $valor;
    echo "<br>";
 
}
echo "</ul>";

}
?>