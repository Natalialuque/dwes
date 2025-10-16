<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


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
    <h1>EJERCICIOS</h1>
    <ul>
        <li><a href="/aplicacion/practica1/index.php">Práctica 1</a></li> 
        <li><a href="/aplicacion/practica2/index.php">Práctica 2</a></li> 
        <li><a href="/aplicacion/practica3/index.php">Práctica 3</a></li> 


    </ul>   
    <h1>PRUEBAS </h1>
    <ul>
       <li><a href="/aplicacion/pruebas/index.php">Pruebas</a></li>
    </ul>

<?php
}
