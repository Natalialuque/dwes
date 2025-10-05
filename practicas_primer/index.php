<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador




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
    <ul>
        <li><a href="/aplicacion/pruebas/index.php">Pruebas</a></li>
        <li><a href="/aplicacion/practica1/index.php">Práctica 1</a></li> 
    </ul>   

<?php
}
