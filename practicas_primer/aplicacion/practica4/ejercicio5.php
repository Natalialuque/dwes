<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 4"=> "./index.php",
 "Ejercicio 5"=>"ejercicio5.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 4");
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
//EstadoCivil
//Persona

// Obtener todos los casos posibles del enum EstadoCivil
    $estados = EstadoCivil::cases();

    // Seleccionar uno aleatoriamente
    $estadoAleatorio = $estados[array_rand($estados)];

    // Mostrarlo llamando a registrarPersona dandole parámetros para todo y el estado aleatorio
    $obj = Persona::registrarPersona("Alejandro", "02/08/2005", "Calle nueva", "El trabuco", $estadoAleatorio);
    echo $obj;

}
?>