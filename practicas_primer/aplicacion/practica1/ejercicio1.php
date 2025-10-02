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
// Variables en distintas bases
$binario = 0b1010;       // Binario (10 en decimal)
$octal = 012;            // Octal (10 en decimal)
$hexadecimal = 0xA;      // Hexadecimal (10 en decimal)

// Resultados en decimal
$binario_decimal = $binario;
$octal_decimal = $octal;
$hexadecimal_decimal = $hexadecimal;

// Funciones matemáticas
$numero = 7.65;
$resultado_round = round($numero);
$resultado_floor = floor($numero);
$resultado_pow = pow(2, 5);
$resultado_sqrt = sqrt(49);
$resultado_dechex = dechex(255);
$base4 = "123";
$base4_decimal = base_convert($base4, 4, 10);
$base4_base8 = base_convert($base4, 4, 8);
$resultado_abs = abs(-15);
$resultado_max = max(3, 7, 2, 9);

//AQUI CERRAMOS EL PHP PARA PONER HTML
?>  
   <h1>Funciones Matemáticas en PHP</h1>

    <h2>Variables en distintas bases</h2>
    <ul>
        <li>Binario 0b1010 = <?= $binario_decimal ?> (decimal)</li>
        <li>Octal 012 = <?= $octal_decimal ?> (decimal)</li>
        <li>Hexadecimal 0xA = <?= $hexadecimal_decimal ?> (decimal)</li>
    </ul>

    <h2>Resultados de funciones matemáticas</h2>
    <ul>
        <li>round(<?= $numero ?>) = <?= $resultado_round ?></li>
        <li>floor(<?= $numero ?>) = <?= $resultado_floor ?></li>
        <li>pow(2, 5) = <?= $resultado_pow ?></li>
        <li>sqrt(49) = <?= $resultado_sqrt ?></li>
        <li>dechex(255) = <?= $resultado_dechex ?></li>
        <li>Base 4 (<?= $base4 ?>) en decimal = <?= $base4_decimal ?></li>
        <li>Base 4 (<?= $base4 ?>) en base 8 = <?= $base4_base8 ?></li>
        <li>abs(-15) = <?= $resultado_abs ?></li>
        <li>max(3, 7, 2, 9) = <?= $resultado_max ?></li>
    </ul>
<?php
//AQUI VOLVEMOS A ABRIR EL PHP PARA LLAMAR AL CODIGO PHP GENERADO ARRIBA
}
?>