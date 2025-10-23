<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 4"=> "./index.php",
 "Ejercicio 4"=>"ejercicio4.php"

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
//Flauta
 $array = ["edad" => 12, "material" => "metal"];
    $obj = Flauta::crearDesdeArray($array);
    $obj2 = clone $obj;

    echo $obj . "<br>";
    echo $obj2;
}
?>