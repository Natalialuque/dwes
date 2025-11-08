
 <?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


//dibuja la plantilla de la vista
inicioCabecera("TIENDA");
cabecera();
finCabecera();
inicioCuerpo("TIENDA MUEBLES");
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
    <h1>TIENDA MUEBLES</h1>
    <ul>
        <a href="/aplicacion/principal/index.php">prueba 1</a>
    </ul>
    

<?php
} 