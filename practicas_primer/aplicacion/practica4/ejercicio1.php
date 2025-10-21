<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 4"=> "./index.php",
 "Ejercicio 1"=>"ejercicio1.php"

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
//InstrumentoBase

// Para clase pública
    $instrumentoBase = new InstrumentoBase("Flauta dulce");
    $instrumentoBase2 = new InstrumentoBase("El viento", 12);

    echo $instrumentoBase;
    echo $instrumentoBase2;

    echo $instrumentoBase->envejecer() . "<br>";
    echo $instrumentoBase->afinar() . "<br>";
    echo $instrumentoBase->sonido("aire") . "<br>"; 

}
?>