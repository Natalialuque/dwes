<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


$ubicacion = [
 "area personal"=> "../../index.php",
 "Pruebas"=> "./index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

//controlador




//dibuja la plantilla de la vista
inicioCabecera("pruebas");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************
 
//vista
function cabecera() 
{}

//vista
function cuerpo()
{
?>
   <a href="sintaxisBasica.php">Pruebas sintaxis básica</a><br>
   <a href="arrays.php">Pruebas arrays</a><br>
<?php
}