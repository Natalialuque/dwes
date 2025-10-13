<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "relacion 2"=> "./index.php",
 "Ejercicio 4"=>"ejercicio4.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

 //CONTROLADOR 
 $numero1 = 17.5;
$numero2 = 379987.24;

// Formatear con coma decimal y punto de miles
$numero1Modificado = number_format($numero1, 1, ',', '');
$numero2Modificado = number_format($numero2, 2, ',', '.');

// Rellenar hasta 15 caracteres
$valor1Final = '-' . str_pad($numero1Modificado, 15, '0', STR_PAD_LEFT) . '-';
$valor2Final = '-' . str_pad($numero2Modificado, 15, ' ', STR_PAD_LEFT) . '-';


//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 2");
cuerpo($valor1Final,$valor2Final);  //llamo a la vista
finCuerpo();

function cabecera(){
   
}


//Aqui vamos añadir todo el codigo de las funciones matematicas
//vista
function cuerpo($valor1Final,$valor2Final)
{

echo "<h3>Primer valor:</h3> $valor1Final\n";
echo "<h3>Segundo valor:</h3> $valor2Final\n";
}