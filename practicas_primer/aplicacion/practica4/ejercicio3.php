<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

require_once("../../../scripts/clases/InstrumentoViento.php");


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 4"=> "./index.php",
 "Ejercicio 3"=>"ejercicio3.php"

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
//IntrumentoViento

//$viento = new InstrumentoViento("metal",20);
$viento2=new InstrumentoViento();

//echo $viento;
echo"<br>";
echo $viento2;

}
?>