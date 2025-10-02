<?php

/**
* 1.- Mostrar el funcionamiento de diversas funciones Matemáticas (round, floor, pow, sqrt, entero a 
*   hexadecimal, de base 4 a base 8 y al menos dos funciones mas distintas de las anteriores) (buscar la 
*   información sobre las funciones matemáticas en http://php.net/manual/es/book.math.php). Definir 
*   variables inicializadas con valores en binario, octal y hexadecimal. Mostrar el valor de esas variables 
*   tanto en decimal como en la base en la que se han definido. 
*/

include_once(dirname(__FILE__) . "/../../cabecera.php");

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 1");
cuerpo();  //llamo a la vista
finCuerpo();


//vista
function cabecera() 
{}



//Aqui vamos añadir todo el codigo de las funciones matematicas
//vista
function cuerpo()
{

 echo "<h3> Funciones matematicas</h3>";

//funciones matematicas
echo "<ul>";

$resultado_round = round(4.7);
echo "<li>El resultado del redondeo (4.7) es: $resultado_round</li>";

$resultado_floor = floor(5.2);
echo "<li>El resultado de floor(5.2) es: $resultado_floor</li>";

$resultado_pow = pow(2, 5);
echo "<li>El resultado de pow(2, 5) es: $resultado_pow</li>";

$resultado_sqrt = sqrt(49);
echo "<li>El resultado de sqrt(49) es: $resultado_sqrt</li>";

$resultado_dechex = dechex(25);
echo "<li>El resultado de dechex(25) es: $resultado_dechex</li>";

$base4_base8 = base_convert(123, 4, 8);
echo "<li>El resultado de convertir 123 de base 4 a base 8 es: $base4_base8</li>";

$resultado_abs = abs(-15);
echo "<li>El resultado de abs(-15) es: $resultado_abs</li>";

$resultado_max = max(3, 7, 2, 9);
echo "<li>El resultado de max(3, 7, 2, 9) es: $resultado_max</li>";

echo "</ul>";


 echo "<h3> Binario, Octal y Hexadecimal</h3>";

 // Variables en distintas bases
 $binario = 0b1010;       // Binario (10 en decimal)
 $octal = 013;            // Octal (10 en decimal)
 $hexadecimal = 0xC;      // Hexadecimal (10 en decimal)

 // Resultados en decimal
 echo "<ul>";
 $binario_decimal = $binario;
    echo "<li>El valor en decimal de la variable binario (0b1010) es: $binario_decimal</li>";
 $octal_decimal = $octal;
    echo "<li>El valor en decimal de la variable octal (012) es: $octal_decimal</li>";
 $hexadecimal_decimal = $hexadecimal;
    echo "<li>El valor en decimal de la variable hexadecimal (0xA) es: $hexadecimal_decimal</li>";
echo "</ul>";
}
?>