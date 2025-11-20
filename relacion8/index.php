
 <?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


//COnTADOR DE cookies
$contador = isset($_COOKIE["contador"]) ? $_COOKIE["contador"] : 0;
$contador++;
setcookie("contador",(string)$contador);

//dibuja la plantilla de la vista
inicioCabecera("RELACION 8");
cabecera();
finCabecera();
inicioCuerpo("RELACION 8");
cuerpo($contador);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {
    
}

//vista
function cuerpo($contador)
{
?>
    <h1>RELACION 8</h1>
    <ul>
        <a href="/aplicacion/personalizar/personalizar.php">personalizar</a>
        <br>
        <h8>Has entrado a esta página <?= $contador ?> veces</h8>
    </ul>
    <ul>
         <a href="/aplicacion/texto/verTextos.php">Textos</a>
    </ul>
    

<?php

} 