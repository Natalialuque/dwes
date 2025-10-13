<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "relacion 2"=> "./index.php",
 "Ejercicio 5"=>"ejercicio5.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

 //CONTROLADOR 
 // Cadena multilínea con HEREDOC
$texto = <<<HTML
<p>Bienvenida a la práctica</p>
<p> 89 </p>
natalia@ejemplo.com
Visitas: 12345 
HTML;

// Expresiones regulares
$regexEtiqueta = '/<[^>]+>/';                      // etiqueta HTML
$regexNumero = '/\b\d+\b/';                        // números 
$regexEmail = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/'; // correos electrónicos

// Resultados para almacenar ca cosa 
$resultados1 = [];
$resultados2 = [];
$resultados3 = [];


if (preg_match($regexEtiqueta, $texto, $matchEtiqueta, PREG_OFFSET_CAPTURE)) { //preg_offest_capture almacena tambien la posicion
    $resultados1['etiqueta'] = $matchEtiqueta[0]; 
} 

if (preg_match($regexNumero, $texto, $matchNumero, PREG_OFFSET_CAPTURE)) {
    $resultados2['numero'] = $matchNumero[0];
}

if (preg_match($regexEmail, $texto, $matchEmail, PREG_OFFSET_CAPTURE)) {
    $resultados3['email'] = $matchEmail[0];
}


//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 2");
cuerpo($resultados1,$resultados2,$resultados3);  //llamo a la vista
finCuerpo();

function cabecera(){
   
}

//vista
function cuerpo($resultados1,$resultados2,$resultados3)
{
    echo "<h3>Resultados encontrados:</h3>";
if (isset($resultados1['etiqueta'])) {
    echo "<p><strong>Etiqueta encontrada:</strong> {$resultados1['etiqueta'][0]} en posición {$resultados1['etiqueta'][1]}</p>";
}

if (isset($resultados2['numero'])) {
    echo "<a><strong>Número encontrado:</strong> {$resultados2['numero'][0]} en posición {$resultados2['numero'][1]}</a>";
}

if (isset($resultados3['email'])) {
    echo "<p><strong>Email encontrado:</strong> {$resultados3['email'][0]} en posición {$resultados3['email'][1]}</p>";
}
}