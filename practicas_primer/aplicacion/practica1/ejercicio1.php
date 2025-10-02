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


//Aqui vamos añadir todo el codigo de las funciones matematicas
//vista
function cuerpo()
{



//funciones matematicas
$resultado_round = round(4.7);
echo "El resultado de round(4.7) es: $resultado_round<br>";

$resultado_floor = floor(5.2);
echo "El resultado de floor(5.2) es: $resultado_floor<br>";

$resultado_pow = pow(2, 5);
echo "El resultado de pow(2, 5) es: $resultado_pow<br>";

$resultado_sqrt = sqrt(49);
echo "El resultado de sqrt(49) es: $resultado_sqrt<br>";

$resultado_dechex = dechex(255);
echo "El resultado de dechex(255) es: $resultado_dechex<br>";

$base4_base8 = base_convert(123, 4, 8);
echo "El resultado de convertir 123 de base 4 a base 8 es: $base4_base8<br>";

// Variables en distintas bases
$binario = 0b1010;       // Binario (10 en decimal)
$octal = 012;            // Octal (10 en decimal)
$hexadecimal = 0xA;      // Hexadecimal (10 en decimal)

// Resultados en decimal
$binario_decimal = $binario;
$octal_decimal = $octal;
$hexadecimal_decimal = $hexadecimal;

// Funciones matemáticas
$base4 = "123";
$base4_decimal = base_convert($base4, 4, 10);
$base4_base8 = base_convert($base4, 4, 8);
$resultado_abs = abs(-15);
$resultado_max = max(3, 7, 2, 9);


}
?>