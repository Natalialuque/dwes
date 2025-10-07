<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "relacion 2"=> "./index.php",
 "Ejercicio 4"=>"ejercicio4.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 2");
cuerpo();  //llamo a la vista
finCuerpo();

function cabecera(){
   
}


//Aqui vamos añadir todo el codigo de las funciones matematicas
//vista
function cuerpo()
{
}