
 <?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

if(isset($_POST["cerrarSesion"])) $acceso->quitarUsuario();


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
     global $acceso;

    if ($acceso->hayUsuario()) {
        echo "<div class='usuario'>Bienvenida, <strong>" . $acceso->getNombre() . "</strong></div>";
    } else {
        echo "<div><a href='/aplicacion/acceso/login.php'>Iniciar sesión</a></div>";
    }
    
}

//vista
function cuerpo($contador)
{
?>
       <h2>Has accedido a esta página <?= $contador ?> veces</h2>


<?php

} 