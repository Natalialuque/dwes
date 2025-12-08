<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "index.php",

 ];



//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
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


<?php
}
