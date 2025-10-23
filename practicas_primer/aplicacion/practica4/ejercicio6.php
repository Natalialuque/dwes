<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 4"=> "./index.php",
 "Ejercicio 6"=>"ejercicio6.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 4");
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 

{
    //SerieFibonacci
}

//vista
function cuerpo()
{
    //SerieFibonacci
    echo"<h4>Serie de fibonacci</h4>";
    foreach (new SerieFibonacci(10) as $valor) {
    echo "$valor&nbsp;";

    // echo"<h4>Serie de fibonacci, llamada de la misma serieFibonacci</h4>";
    // foreach (SerieFibonacci::fFibonacci(10) as $valor) {
    //     echo "$valor&nbsp;";
    // }
}

}
?>